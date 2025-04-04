<?php

namespace App\Twig\Components\Blog;

use App\Repository\BlogRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class CountBlogpost
{
    use DefaultActionTrait;

    public function __construct(
        private BlogRepository $blogRepository
    ) {}

    public function getNbBlogposts(): int
    {
        return $this->blogRepository->count([]);
    }
}
