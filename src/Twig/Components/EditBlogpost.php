<?php

namespace App\Twig\Components;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[AsLiveComponent]
final class EditBlogpost
{
    use DefaultActionTrait;

    use ValidatableComponentTrait;

    #[LiveProp(writable:['title', 'content'])]
    #[Assert\Valid]
    public Blog $blogpost;

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
}
