<?php

namespace App\Twig\Components;

use App\Entity\Photo;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ModalPhotoComponent
{
    use DefaultActionTrait;

    #[LiveProp()]
    public ?string $id = null;

    #[LiveProp()]
    public ?Photo $photo = null;
}
