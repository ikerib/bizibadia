<?php

namespace App\Controller;

use App\Entity\Gunea;
use App\Form\GuneaType;
use App\Repository\GuneaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/kudeatu/gunea')]
#[IsGranted("ROLE_KUDEATU")]
class GuneaController extends AbstractController
{
    #[Route('/', name: 'app_gunea_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $guneas = $entityManager
            ->getRepository(Gunea::class)
            ->findAll();

        return $this->render('gunea/index.html.twig', [
            'guneas' => $guneas,
        ]);
    }

    #[Route('/new', name: 'app_gunea_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gunea = new Gunea();
        $gunea->setUdala($this->getUser()->getUdala());
        $form = $this->createForm(GuneaType::class, $gunea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gunea);
            $entityManager->flush();

            return $this->redirectToRoute('app_gunea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gunea/new.html.twig', [
            'gunea' => $gunea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gunea_show', methods: ['GET'])]
    public function show(Gunea $gunea): Response
    {
        return $this->render('gunea/show.html.twig', [
            'gunea' => $gunea,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gunea_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gunea $gunea, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GuneaType::class, $gunea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_gunea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gunea/edit.html.twig', [
            'gunea' => $gunea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gunea_delete', methods: ['POST'])]
    public function delete(Request $request, Gunea $gunea, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gunea->getId(), $request->request->get('_token'))) {
            $entityManager->remove($gunea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gunea_index', [], Response::HTTP_SEE_OTHER);
    }
}
