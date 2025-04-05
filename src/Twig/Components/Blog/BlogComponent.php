<?php

namespace App\Twig\Components\Blog;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class BlogComponent
{
    public int $id;
    public string $dataClass = 'm-4';

    public function __construct(
        private BlogRepository $blogRepository,
    ) {
    }

    public function getBlog(): Blog
    {
        return $this->blogRepository->find($this->id);
    }
}
