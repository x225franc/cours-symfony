<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Category;
use App\Entity\PlaylistMedia;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function discover(EntityManagerInterface $entityManager)
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();
        $media = $entityManager->getRepository(Media::class)->findAll();

        return $this->render('movie/discover.html.twig', [
            'categories' => $categories,
            'media' => $media,
        ]);
    }

    #[Route(path: '/lists', name: 'lists')]
    public function lists(EntityManagerInterface $entityManager)
    {
        $playlist_media = $entityManager->getRepository(PlaylistMedia::class)->findAll();

        return $this->render('movie/lists.html.twig', [
            'playlist_media' => $playlist_media,
        ]);
    }
}
