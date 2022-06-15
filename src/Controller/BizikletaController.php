<?php

namespace App\Controller;

use App\Entity\Bizikleta;
use App\Form\BizikletaType;
use App\Repository\BizikletaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/kudeatu/gunea')]
#[IsGranted("ROLE_KUDEATU")]
class BizikletaController extends AbstractController
{
    #[Route('/', name: 'app_bizikleta_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $bizikletas = $entityManager
            ->getRepository(Bizikleta::class)
            ->findAll();

        return $this->render('bizikleta/index.html.twig', [
            'bizikletas' => $bizikletas,
        ]);
    }

    #[Route('/new', name: 'app_bizikleta_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bizikletum = new Bizikleta();
        $bizikletum->setUdala($this->getUser()->getUdala());
        $form = $this->createForm(BizikletaType::class, $bizikletum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bizikletum);
            $entityManager->flush();

            return $this->redirectToRoute('app_bizikleta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bizikleta/new.html.twig', [
            'bizikletum' => $bizikletum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bizikleta_show', methods: ['GET'])]
    public function show(Bizikleta $bizikletum): Response
    {
        return $this->render('bizikleta/show.html.twig', [
            'bizikletum' => $bizikletum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bizikleta_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bizikleta $bizikletum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BizikletaType::class, $bizikletum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bizikleta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bizikleta/edit.html.twig', [
            'bizikletum' => $bizikletum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bizikleta_delete', methods: ['POST'])]
    public function delete(Request $request, Bizikleta $bizikletum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bizikletum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bizikletum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bizikleta_index', [], Response::HTTP_SEE_OTHER);
    }
}
