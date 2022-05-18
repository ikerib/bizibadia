<?php

namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Annotations\Reader;

class FilterConfigurator
{
    protected $em;
    protected $tokenStorage;
    protected $reader;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, Reader $reader)
    {
        $this->em              = $em;
        $this->tokenStorage    = $tokenStorage;
        $this->reader          = $reader;
    }

    public function onKernelRequest()
    {
        if ($user = $this->getUser()) {
            $filter = $this->em->getFilters()->enable('UdalaFilter');
            if ($user->getudala()) {
                $filter->setParameter('udala_id', $user->getudala()->getId());
            } else {
                return '' ;
            }
        }
    }

    private function getUser()
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return null;
        }

        $user = $token->getUser();

        if (!($user instanceof UserInterface)) {
            return null;
        }

        return $user;
    }
}
