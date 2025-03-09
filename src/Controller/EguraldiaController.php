<?php

namespace App\Controller;

use App\Entity\Eguraldia;
use App\Form\EguraldiaType;
use App\Repository\EguraldiaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/kudeatu/eguraldia')]
#[IsGranted("ROLE_KUDEATU")]
class EguraldiaController extends AbstractController
{
    #[Route('/', name: 'app_eguraldia_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $eguraldias = $entityManager
            ->getRepository(Eguraldia::class)
            ->findAll();

        return $this->render('eguraldia/index.html.twig', [
            'eguraldias' => $eguraldias,
        ]);
    }

    #[Route('/new', name: 'app_eguraldia_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eguraldium = new Eguraldia();
        $eguraldium->setUdala($this->getUser()->getUdala());
        $form = $this->createForm(EguraldiaType::class, $eguraldium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eguraldium);
            $entityManager->flush();

            return $this->redirectToRoute('app_eguraldia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eguraldia/new.html.twig', [
            'eguraldium' => $eguraldium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eguraldia_show', methods: ['GET'])]
    public function show(Eguraldia $eguraldium): Response
    {
        return $this->render('eguraldia/show.html.twig', [
            'eguraldium' => $eguraldium,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_eguraldia_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Eguraldia $eguraldium, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EguraldiaType::class, $eguraldium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_eguraldia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eguraldia/edit.html.twig', [
            'eguraldium' => $eguraldium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eguraldia_delete', methods: ['POST'])]
    public function delete(Request $request, Eguraldia $eguraldium, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eguraldium->getId(), $request->request->get('_token'))) {
            $entityManager->remove($eguraldium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_eguraldia_index', [], Response::HTTP_SEE_OTHER);
    }
}
