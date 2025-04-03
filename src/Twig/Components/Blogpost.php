<?php

namespace App\Twig\Components;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Blogpost
{
    public int $id;

    public function __construct(
        private BlogRepository $blogRepository,
    ) {
    }

    public function getBlogpost(): Blog
    {
        return $this->blogRepository->find($this->id);
    }

}
