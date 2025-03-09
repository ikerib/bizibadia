<?php

namespace App\Controller;

use App\Repository\GuneaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(GuneaRepository $guneaRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'guneak' => $guneaRepository->findAll()
        ]);
    }

    #[Route('/change-locale', name: 'change-locale')]
    public function changeLocale(Request $request): Response
    {
        $locale = $request->getLocale();

        return $this->redirectToRoute('app_user_index', ['_locale' => $locale], 301);
    }

    #[Route('/access-denied', name: 'access-denied')]
    public function accessDenied(Request $request): Response
    {
        return $this->render('default/access-denied.html.twig');
    }



}
