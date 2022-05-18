<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    public const EDIT = 'edit';
    public const VIEW = 'view';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                $isAdminToEdit = false;
                if (in_array('ROLE_ADMIN', $subject->getRoles(), true)) {
                    $isAdminToEdit = true;
                }

                // Now we know that the user to edit is ROLE_ADMIN, so we need to be ROLE_ADMIN or ROLE_SUPER_ADMIN
                if ($isAdminToEdit) {
                    if ((in_array('ROLE_ADMIN', $user->getRoles(), true)) || (in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true))){
                        return true;
                    } else {
                        return false;
                    }
                }

                return true;
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
