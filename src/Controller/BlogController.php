<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BlogController extends AbstractController
{
    public function __construct(
        private BlogRepository $blogRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    #[Route("/blog", "app_blog")]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig');
    }

    #[Route('/search','app_search')]
    public function search(): Response
    {
        return $this->render('blog/search.html.twig');
    }

    #[Route('blog/edit/{id}','app_edit')]
    public function edit(Blog $blog): Response
    {
        return $this->render('blog/edit.html.twig', [
            'blog' => $blog,
        ]);
    }

    #[Route('/generate','app_generate')]
    public function generate()
    {
        $faker = Factory::create('fr_FR');

        $blogpost = new Blog();

        $blogpost->setTitle($faker->sentence())
            ->setContent($faker->paragraph());

        $this->entityManager->persist($blogpost);
        $this->entityManager->flush();

        dd('Blog post created');
    }
}
