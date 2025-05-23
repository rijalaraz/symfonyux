<?php

namespace App\Twig\Components\Blog;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[AsLiveComponent]
final class EditBlogComponent
{
    use DefaultActionTrait;

    use ValidatableComponentTrait;

    #[LiveProp(writable:['title', 'content'])]
    #[Assert\Valid]
    public Blog $blog;

    public bool $is_edited = false;

    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    #[LiveAction]
    public function save()
    {
        $this->validate();

        $this->is_edited = true;
        $this->em->flush();
    }

    #[LiveListener('titleChanged')]
    public function createSlug(#[LiveArg] string $slug)
    {
        $this->blog->setContent($slug);
    }
}
