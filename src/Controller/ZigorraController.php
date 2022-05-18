<?php

namespace App\Controller;

use App\Entity\Zigorra;
use App\Form\ZigorraType;
use App\Repository\ZigorraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/kudeatu/zigorra')]
#[IsGranted("ROLE_KUDEATU")]
class ZigorraController extends AbstractController
{
    #[Route('/', name: 'app_zigorra_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $zigorras = $entityManager
            ->getRepository(Zigorra::class)
            ->findAll();

        return $this->render('zigorra/index.html.twig', [
            'zigorras' => $zigorras,
        ]);
    }

    #[Route('/new', name: 'app_zigorra_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $zigorra = new Zigorra();
        $zigorra->setUdala($this->getUser()->getUdala());
        $form = $this->createForm(ZigorraType::class, $zigorra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($zigorra);
            $entityManager->flush();

            return $this->redirectToRoute('app_zigorra_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('zigorra/new.html.twig', [
            'zigorra' => $zigorra,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_zigorra_show', methods: ['GET'])]
    public function show(Zigorra $zigorra): Response
    {
        return $this->render('zigorra/show.html.twig', [
            'zigorra' => $zigorra,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_zigorra_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Zigorra $zigorra, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ZigorraType::class, $zigorra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_zigorra_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('zigorra/edit.html.twig', [
            'zigorra' => $zigorra,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_zigorra_delete', methods: ['POST'])]
    public function delete(Request $request, Zigorra $zigorra, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$zigorra->getId(), $request->request->get('_token'))) {
            $entityManager->remove($zigorra);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_zigorra_index', [], Response::HTTP_SEE_OTHER);
    }
}
