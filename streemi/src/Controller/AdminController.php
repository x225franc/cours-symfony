<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\Voter\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route(path: '/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig');
    }

    #[Route(path: '/admin/film', name: 'admin_film')]
    public function admin_film(): Response
    {
        return $this->render('admin/admin_films.html.twig');
    }

    #[Route(path: '/admin/add_film', name: 'admin_add_film')]
    public function admin_add_film(): Response
    {
        return $this->render('admin/admin_films.html.twig');
    }

    #[Route(path: '/admin/users', name: 'admin_users')]
    public function admin_users(): Response
    {
        return $this->render('admin/admin_users.html.twig');
    }

    #[Route('/admin/movies', name: 'admin-movies')]
    public function movies(): Response
    {
        return $this->render('admin/admin_movies.html.twig');
    }

    #[Route('/admin/movies/add', name: 'admin-add-movies')]
    public function addMovie(): Response
    {
        return $this->render('admin/admin_add_movies.html.twig');
    }
}
