<?php /** @noinspection ALL */

namespace App\Controller;

use App\Entity\ErabiltzaileZigorra;
use App\Entity\Mailegua;
use App\Entity\User;
use App\Entity\Zigorra;
use App\Form\MaileguaFinderType;
use App\Form\MaileguaFindType;
use App\Form\MaileguaFinType;
use App\Form\MaileguaHasiType;
use App\Form\MaileguaType;
use App\Form\MaileguaZigorraType;
use App\Repository\MaileguaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

#[Route('/{_locale}/kudeatu/mailegua')]
#[IsGranted("ROLE_KUDEATU")]
class MaileguaController extends AbstractController
{
    #[Route('/', name: 'app_mailegua_index', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('mailegua/index.html.twig');
    }

    #[Route('/list', name: 'app_mailegua_list', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $maileguas = $entityManager
            ->getRepository(Mailegua::class)
            ->findAll();

        return $this->render('mailegua/list.html.twig', [
            'maileguas' => $maileguas,
        ]);
    }

    #[Route('/erabiltzailea', name: 'app_mailegua_erabiltzailea_select', methods: ['GET', 'POST'])]
    public function erabiltzaileaselect(Request $request, EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        $defaultData = ['message' => 'Erabiltzailea'];
        $form = $this->createFormBuilder($defaultData)
            ->add('nan', TextType::class)
            ->add('bilatu', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData('nan');
            $user = $entityManager->getRepository(User::class)->findUserWithNoFilter($data['nan']);

            if ($user) {
                return $this->redirectToRoute('app_mailegua_hasi', ['userid' => $user->getId()]);
            } else {
                // Call API to Avoid Doctrine filter
                $url = "/api/users?nan=" . $data['nan'];
                $response = $this->client->request('GET', $url);
                $parsedResponse = $response->toArray();
                return $parsedResponse['value'];

            }
        }

        return $this->renderForm('mailegua/00-user_select.html.twig', [
            'users' => $users,
            'form' => $form
        ]);
    }

    #[Route('/hasi/{userid}', name: 'app_mailegua_hasi', methods: ['GET', 'POST'])]
    public function hasi(Request $request, EntityManagerInterface $entityManager, $userid): Response
    {
        $mailegua = new Mailegua();
        $mailegua->setUdala($this->getUser()->getUdala());

        $user = $entityManager->getRepository(User::class)->find($userid);
        $mailegua->setErabiltzailea($user);
        $form = $this->createForm(MaileguaHasiType::class, $mailegua);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailegua->getBizikleta()->setIsAlokatuta(true);
            $mailegua->getBizikleta()->setGunea(null);
            $mailegua->getErabiltzailea()->setCanRent(false);
            $entityManager->persist($mailegua);
            $entityManager->flush();

            return $this->redirectToRoute('app_mailegua_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mailegua/hasi.html.twig', [
            'mailegua' => $mailegua,
            'form' => $form,
        ]);
    }

    #[Route('/itzulketa', name: 'app_mailegua_itzulketa', methods: ['GET'])]
    public function itzulketa(Request $request, MaileguaRepository $maileguaRepository): Response
    {
        $mailegua = new Mailegua();
        $mailegua->setUdala($this->getUser()->getUdala());
        $formFinder = $this->createForm(MaileguaFinderType::class, $mailegua, [
            'method' => 'GET',
            'action' => $this->generateUrl('app_mailegua_itzulketa')
        ]);
        $formFinder->handleRequest($request);

        if ($formFinder->isSubmitted() && $formFinder->isValid()) {
            $filter = $formFinder->getData();

            return $this->render('mailegua/itzulketa.html.twig', [
                'form' => $formFinder->createView(),
                'finderMaileguak' => $maileguaRepository->getByFinder($filter),
                'lastMaileguak' => $maileguaRepository->getLastTen()
            ]);
        }

        return $this->render('mailegua/itzulketa.html.twig', [
            'form' => $formFinder->createView(),
            'lastMaileguak' => $maileguaRepository->getLastTen()
        ]);
    }

    #[Route('/{id}/itzuli', name: 'app_mailegua_itzuli', methods: ['GET', 'POST'])]
    public function itzuli(Request $request, Mailegua $mailegua, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaileguaFinType::class, $mailegua, [
            'method' => 'POST',
            'action' => $this->generateUrl('app_mailegua_itzuli', ['id' => $mailegua->getId()])
        ]);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {
            $mailegua->setUpdatedAt(new \DateTime());
            $mailegua->getBizikleta()->setIsAlokatuta(false);
            $mailegua->getBizikleta()->setGunea($mailegua->getEndGunea());
            $mailegua->getErabiltzailea()->setCanRent(true);
            $entityManager->persist($mailegua);
            $entityManager->flush();
            return $this->redirectToRoute('app_mailegua_zigorra_matxura', ['id' => $mailegua->getId()]);
        }

        return $this->render('mailegua/itzuli.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/amaitu', name: 'app_mailegua_zigorra_matxura', methods: ['GET', 'POST'])]
    public function zigorramatxura(Request $request, Mailegua $mailegua, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaileguaZigorraType::class, $mailegua, [
            'method' => 'POST',
            'action' => $this->generateUrl('app_mailegua_zigorra_matxura', ['id' => $mailegua->getId()])
        ]);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {

            /** @var Mailegua $data */
            $data = $form->getData();

            if ( $data->getZigorra() ) {
                $zigorra = $data->getZigorra();
                $erab = $data->getErabiltzailea();
                $ez = new ErabiltzaileZigorra();
                $ez->setErabiltzailea($erab);
                $ez->setZigorra($zigorra);
                $ez->setDateStart(new \DateTime());
                if ( $zigorra->getEgunak()) {
                    $d = new \DateTime();
                    $egunak = $zigorra->getEgunak();
                    $d->modify("$egunak day");
                    $ez->setDateEnd($d);
                }
                $entityManager->persist($ez);
                $entityManager->flush();
            }

            $matxura = $form['matxura']->getData();
            if ( $matxura ) {
                $bizikleta = $data->getBizikleta();
                $bizikleta->setOharrak($matxura);
                $entityManager->persist($bizikleta);
                $entityManager->flush();
            }



            return $this->redirectToRoute('app_mailegua_index');
        }

        return $this->render('mailegua/zigorra.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mailegua_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mailegua $mailegua, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaileguaType::class, $mailegua);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mailegua_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mailegua/edit.html.twig', [
            'mailegua' => $mailegua,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mailegua_delete', methods: ['POST'])]
    public function delete(Request $request, Mailegua $mailegua, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mailegua->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mailegua);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mailegua_index', [], Response::HTTP_SEE_OTHER);
    }
}
