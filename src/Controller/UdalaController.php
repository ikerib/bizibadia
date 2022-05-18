<?php

namespace App\Controller;

use App\Entity\Udala;
use App\Form\UdalaType;
use App\Repository\UdalaRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/admin/udala')]
#[IsGranted("ROLE_SUPER_ADMIN")]
class UdalaController extends AbstractController
{
    #[Route('/', name: 'app_udala_index', methods: ['GET'])]
    public function index(UdalaRepository $udalaRepository): Response
    {
        return $this->render('udala/index.html.twig', [
            'udalas' => $udalaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_udala_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UdalaRepository $udalaRepository): Response
    {
        $udala = new Udala();
        $form = $this->createForm(UdalaType::class, $udala, [
            'action' => $this->generateUrl('app_udala_new'),
            'method' => 'POST'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $udalaRepository->add($udala);
            return $this->redirectToRoute('app_udala_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('udala/new.html.twig', [
            'udala' => $udala,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_udala_show', methods: ['GET'])]
    public function show(Udala $udala): Response
    {
        return $this->render('udala/show.html.twig', [
            'udala' => $udala,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_udala_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Udala $udala, UdalaRepository $udalaRepository): Response
    {
        $form = $this->createForm(UdalaType::class, $udala);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $udalaRepository->add($udala);
            return $this->redirectToRoute('app_udala_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('udala/edit.html.twig', [
            'udala' => $udala,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_udala_delete', methods: ['POST'])]
    public function delete(Request $request, Udala $udala, UdalaRepository $udalaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$udala->getId(), $request->request->get('_token'))) {
            $udalaRepository->remove($udala);
        }

        return $this->redirectToRoute('app_udala_index', [], Response::HTTP_SEE_OTHER);
    }
}
