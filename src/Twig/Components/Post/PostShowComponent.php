<?php

namespace App\Twig\Components\Post;

use App\Entity\Post;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class PostShowComponent
{
    use DefaultActionTrait;

    #[LiveProp()]
    public ?Post $post = null;

}
