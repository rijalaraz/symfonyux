<?php

namespace App\Twig\Components;

use App\Repository\BlogRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class AllBlogpost
{
    public function __construct(
        private BlogRepository $blogRepository,
    ) {

    }

    public function getAllBlogposts(): array
    {
        return $this->blogRepository->findAll();
    }
}
