<?php

namespace App\Twig\Components\Blog;

use App\Repository\BlogRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class BlogSearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)] 
    public string $query = "";

    public function __construct(
        private BlogRepository $blogRepository
    ) {
    }

    public function getBlogs(): array
    {
        return $this->blogRepository->findByQuery($this->query);
    }
}
