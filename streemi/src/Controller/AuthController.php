<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Subscription;
use Doctrine\ORM\Mapping\Entity;
use App\Enum\UserAccountStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;


class AuthController extends AbstractController
{

    #[Route(path: '/confirm', name: 'confirm')]

    public function confirm()
    {
        return $this->render('auth/confirm.html.twig');
    }

    #[Route(path: '/forgot', name: 'forgot')]

    public function forgot()
    {
        return $this->render('auth/forgot.html.twig');
    }

    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(Security $security): Response
    {
        $response = $security->logout();

        return $this->redirectToRoute('home');
    }


    #[Route(path: '/register', name: 'register')]

    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // Fetch the Subscription entity (assuming you have a default subscription with ID 1)
            // $subscription = $entityManager->getRepository(Subscription::class)->find(1);

            // if ($subscription) {
            //     $user->setSubscription($subscription);
            // } else {
            //     // Handle the case where the subscription is not found
            //     $this->addFlash('error', 'Subscription not found.');
            //     return $this->redirectToRoute('register');
            // }

            $user->setAccountStatus(UserAccountStatusEnum::VALID);
            $user->setRoles(['ROLE_USER']);

            // Hash the password
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('login');

        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/reset', name: 'reset')]

    public function reset()
    {
        return $this->render('auth/reset.html.twig');
    }
}
