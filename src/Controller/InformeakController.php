<?php

namespace App\Controller;

use App\Entity\Bizikleta;
use App\Entity\Gunea;
use App\Entity\Mailegua;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformeakController extends AbstractController
{
    #[Route('/informeak', name: 'app_informeak')]
    public function index(EntityManagerInterface $em): Response
    {
        $countUsers = $em->getRepository(User::class)->findAll();
        $countRents = $em->getRepository(Mailegua::class)->findAll();
        $guneak     = $em->getRepository(Gunea::class)->findAll();
        $bizikletak = $em->getRepository(Bizikleta::class)->findAll();
        $monthly    = $em->getRepository(Mailegua::class)->countByMonth();

        return $this->render('informeak/index.html.twig', [
            'users'         => $countUsers,
            'maileguak'     => $countRents,
            'guneak'        => $guneak,
            'bizikletak'    => $bizikletak,
            'monthly'       => $monthly
        ]);
    }
}
