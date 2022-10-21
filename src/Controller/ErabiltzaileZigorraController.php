<?php

namespace App\Controller;

use App\Entity\ErabiltzaileZigorra;
use App\Form\ErabiltzaileZigorraType;
use App\Repository\ErabiltzaileZigorraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/erabiltzaile/zigorra')]
class ErabiltzaileZigorraController extends AbstractController
{
    #[Route('/', name: 'app_erabiltzaile_zigorra_index', methods: ['GET'])]
    public function index(ErabiltzaileZigorraRepository $erabiltzaileZigorraRepository): Response
    {
        return $this->render('erabiltzaile_zigorra/index.html.twig', [
            'erabiltzaile_zigorras' => $erabiltzaileZigorraRepository->findAll(),
        ]);
    }

    #[Route('/user/{userid}/list', name: 'app_erabiltzaile_zigorra_user', methods: ['GET'])]
    public function erabiltzailezigorrauser(ErabiltzaileZigorraRepository $erabiltzaileZigorraRepository, $userid): Response
    {
        dump($erabiltzaileZigorraRepository->findAllFromUser($userid));
        return $this->render('erabiltzaile_zigorra/index.html.twig', [
            'erabiltzaile_zigorras' => $erabiltzaileZigorraRepository->findAllFromUser($userid),
        ]);
    }

    #[Route('/new', name: 'app_erabiltzaile_zigorra_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ErabiltzaileZigorraRepository $erabiltzaileZigorraRepository): Response
    {
        $erabiltzaileZigorra = new ErabiltzaileZigorra();
        $form = $this->createForm(ErabiltzaileZigorraType::class, $erabiltzaileZigorra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $erabiltzaileZigorraRepository->add($erabiltzaileZigorra, true);

            return $this->redirectToRoute('app_erabiltzaile_zigorra_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('erabiltzaile_zigorra/new.html.twig', [
            'erabiltzaile_zigorra' => $erabiltzaileZigorra,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_erabiltzaile_zigorra_show', methods: ['GET'])]
    public function show(ErabiltzaileZigorra $erabiltzaileZigorra): Response
    {
        return $this->render('erabiltzaile_zigorra/show.html.twig', [
            'erabiltzaile_zigorra' => $erabiltzaileZigorra,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_erabiltzaile_zigorra_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ErabiltzaileZigorra $erabiltzaileZigorra, ErabiltzaileZigorraRepository $erabiltzaileZigorraRepository): Response
    {
        $form = $this->createForm(ErabiltzaileZigorraType::class, $erabiltzaileZigorra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $erabiltzaileZigorraRepository->add($erabiltzaileZigorra, true);

            return $this->redirectToRoute('app_erabiltzaile_zigorra_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('erabiltzaile_zigorra/edit.html.twig', [
            'erabiltzaile_zigorra' => $erabiltzaileZigorra,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_erabiltzaile_zigorra_delete', methods: ['POST'])]
    public function delete(Request $request, ErabiltzaileZigorra $erabiltzaileZigorra, ErabiltzaileZigorraRepository $erabiltzaileZigorraRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$erabiltzaileZigorra->getId(), $request->request->get('_token'))) {
            $erabiltzaileZigorraRepository->remove($erabiltzaileZigorra, true);
        }

        return $this->redirectToRoute('app_erabiltzaile_zigorra_index', [], Response::HTTP_SEE_OTHER);
    }
}
