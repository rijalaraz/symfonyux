<?php

namespace App\Twig\Components\Post;

use App\Repository\PostRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsLiveComponent]
final class PostListComponent
{
    use DefaultActionTrait;

    public ?array $posts  = [];

    public function __construct(
        private PostRepository $postRepository
    ) {}

    #[PreMount()]
    public function getAllPosts(): void
    {
        $this->posts = $this->postRepository->findAll();
    }
}
