<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function home(EntityManagerInterface $entityManager)
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();
        $media = $entityManager->getRepository(Media::class)->findAll();

        return $this->render('others/index.html.twig', [
            'categories' => $categories,
            'media' => $media,
        ]);
    }

    #[Route(path: '/abonnement', name: 'abonnement')]

    public function abonnement()
    {
        return $this->render('others/abonnements.html.twig');
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
