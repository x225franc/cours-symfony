<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route(path: '/admin', name: 'admin')]

    public function admin()
    {
        return $this->render('admin/admin.html.twig');
    }

    #[Route(path: '/admin/film', name: 'admin_film')]

    public function admin_film()
    {
        return $this->render('admin/admin_films.html.twig');
    }

    #[Route(path: '/admin/add_film', name: 'admin_add_film')]

    public function admin_add_film()
    {
        return $this->render('admin/admin_films.html.twig');
    }

    #[Route(path: '/admin/users', name: 'admin_users')]

    public function admin_users()
    {
        return $this->render('admin/admin_users.html.twig');
    }
}
