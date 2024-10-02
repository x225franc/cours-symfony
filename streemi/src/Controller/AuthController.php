<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    public function login()
    {
        return $this->render('auth/login.html.twig');
    }

    #[Route(path: '/register', name: 'register')]

    public function register()
    {
        return $this->render('auth/register.html.twig');
    }

    #[Route(path: '/reset', name: 'reset')]

    public function reset()
    {
        return $this->render('auth/reset.html.twig');
    }
}
