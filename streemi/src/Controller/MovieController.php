<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{

    #[Route(path: '/category', name: 'category')]
    public function category()
    {
        return $this->render('movie/category.html.twig');
    }

    #[Route(path: '/detail', name: 'detail')]
    public function detail()
    {
        return $this->render('movie/detail.html.twig');
    }

    #[Route(path: '/detail/serie', name: 'detail_serie')]
    public function detail_serie()
    {
        return $this->render('movie/detail_serie.html.twig');
    }

    #[Route(path: '/discover', name: 'discover')]
    public function discover()
    {
        return $this->render('movie/discover.html.twig');
    }

    #[Route(path: '/lists', name: 'lists')]
    public function lists()
    {
        return $this->render('movie/lists.html.twig');
    }
}
