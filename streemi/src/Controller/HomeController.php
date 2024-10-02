<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function home()
    {
        return $this->render('others/index.html.twig');
    }

    #[Route(path: '/abonnement', name: 'abonnement')]

    public function abonnement()
    {
        return $this->render('others/abonnement.html.twig');
    }

    #[Route(path: '/default', name: 'default')]

    public function default()
    {
        return $this->render('others/default.html.twig');
    }

    #[Route(path: '/upload', name: 'upload')]

    public function upload()
    {
        return $this->render('others/upload.html.twig');
    }
}
