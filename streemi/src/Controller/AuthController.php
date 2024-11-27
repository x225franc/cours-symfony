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

    public function login(EntityManagerInterface $entityManager)
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        return $this->render('auth/login.html.twig');
    }

    #[Route(path: '/register', name: 'register')]

    public function register(Request $request , EntityManagerInterface $entityManager)
    {
        // name , email, password, repassword , account_status

        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $subscription = $entityManager->getRepository(Subscription::class)->find(1);

            if ($subscription) {
                $user->setSubscription($subscription);
            }
            $user->setAccountStatus(UserAccountStatusEnum::VALID);

            // Perform any additional processing, such as encoding the password

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('auth/confirm.html.twig');
        }
        return $this->render('auth/register.html.twig' , [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/reset', name: 'reset')]

    public function reset()
    {
        return $this->render('auth/reset.html.twig');
    }
}
