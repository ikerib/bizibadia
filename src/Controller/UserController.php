<?php

namespace App\Controller;

use App\Entity\ErabiltzaileZigorra;
use App\Entity\User;
use App\Form\NewUserType;
use App\Form\ResetPasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/kudeatu/users')]
#[IsGranted("ROLE_KUDEATU")]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->getUsersWithZigorrak(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        if (!in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles(), true)) {
            $user->setUdala($this->getUser()->getUdala());
        }

        $form = $this->createForm(NewUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwd = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $passwd
            );
            $user->setPassword($hashedPassword);
            $userRepository->add($user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        // ROLE_KUDEATU dutenak ezin dute ROLE_ADMIN editatu
        $this->denyAccessUnlessGranted('edit',$user);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            $request->getSession()->set('_locale', $user->getLanguage());
            return $this->redirectToRoute('app_user_index', ['_locale' => $user->getLanguage()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/change-passwd', name: 'app_user_change_password', methods: ['GET', 'POST'])]
    public function changePasswd(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwd = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $passwd
            );
            $user->setPassword($hashedPassword);
            $userRepository->add($user);
            $request->getSession()->set('_locale', $user->getLanguage());
            return $this->redirectToRoute('app_user_index', ['_locale' => $user->getLanguage()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/change-password.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
