<?php

namespace App\Twig\Components\Blog;

use App\Repository\BlogRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class AllBlogComponent
{
    public function __construct(
        private BlogRepository $blogRepository,
    ) {
    }

    public function getAllBlogs(): array
    {
        return $this->blogRepository->findAll();
    }
}
