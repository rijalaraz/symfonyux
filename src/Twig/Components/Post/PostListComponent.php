<?php

namespace App\Twig\Components\Post;

use App\Repository\PostRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class PostListComponent
{
    use DefaultActionTrait;

    public function __construct(
        private PostRepository $postRepository
    ) {}

    public function getPosts(): array
    {
        return $this->postRepository->findAll();
    }
}
