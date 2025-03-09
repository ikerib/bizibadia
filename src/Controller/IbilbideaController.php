<?php

namespace App\Controller;

use App\Entity\Ibilbidea;
use App\Form\IbilbideaType;
use App\Repository\IbilbideaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/kudeatu/ibilbidea')]
#[IsGranted("ROLE_KUDEATU")]
class IbilbideaController extends AbstractController
{
    #[Route('/', name: 'app_ibilbidea_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $ibilbideas = $entityManager
            ->getRepository(Ibilbidea::class)
            ->findAll();

        return $this->render('ibilbidea/index.html.twig', [
            'ibilbideas' => $ibilbideas,
        ]);
    }

    #[Route('/new', name: 'app_ibilbidea_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ibilbidea = new Ibilbidea();
        $ibilbidea->setUdala($this->getUser()->getUdala());
        $form = $this->createForm(IbilbideaType::class, $ibilbidea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ibilbidea);
            $entityManager->flush();

            return $this->redirectToRoute('app_ibilbidea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ibilbidea/new.html.twig', [
            'ibilbidea' => $ibilbidea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ibilbidea_show', methods: ['GET'])]
    public function show(Ibilbidea $ibilbidea): Response
    {
        return $this->render('ibilbidea/show.html.twig', [
            'ibilbidea' => $ibilbidea,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ibilbidea_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ibilbidea $ibilbidea, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IbilbideaType::class, $ibilbidea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ibilbidea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ibilbidea/edit.html.twig', [
            'ibilbidea' => $ibilbidea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ibilbidea_delete', methods: ['POST'])]
    public function delete(Request $request, Ibilbidea $ibilbidea, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ibilbidea->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ibilbidea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ibilbidea_index', [], Response::HTTP_SEE_OTHER);
    }
}
