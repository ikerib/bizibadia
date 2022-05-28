<?php

namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\FilterCollection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Annotations\Reader;

class FilterConfigurator
{
    protected $em;
    protected $tokenStorage;
    protected $reader;
    protected $requestStack;

    public function __construct(
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        Reader $reader,
        RequestStack $requestStack
    )
    {
        $this->em               = $em;
        $this->tokenStorage     = $tokenStorage;
        $this->reader           = $reader;
        $this->requestStack = $requestStack;
    }

    public function onKernelRequest()
    {
        $route = $this->requestStack->getCurrentRequest()->get('_route');
        $udalaFilter = $this->em->getFilters('UdalaFilter');


        if (($user = $this->getUser()) && (!str_contains($route,'app_mailegua_')) ) {
            if ( !$udalaFilter->isEnabled('UdalaFilter')) {
                $filter = $this->em->getFilters()->enable('UdalaFilter');
            }
            if ($user->getudala()) {
                $filter = $this->em->getFilters()->enable('UdalaFilter');
                $filter->setParameter('udala_id', $user->getudala()->getId());
            } else {
                return '' ;
            }
        } else {
            if ( $udalaFilter->isEnabled('UdalaFilter') ) {
                $filter = $this->em->getFilters()->disable('UdalaFilter');
            }
            return '';
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
