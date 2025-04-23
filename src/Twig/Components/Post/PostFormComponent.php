<?php

namespace App\Twig\Components\Post;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class PostFormComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    /**
     * The initial data used to create the form.
     */
    #[LiveProp()]
    public ?Post $initialFormData = null;

    #[LiveProp]
    public string $buttonLabel = 'Create';

    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(PostType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {
        // Submit the form! If validation fails, an exception is thrown
        // and the component is automatically re-rendered with the errors
        $this->submitForm();

        /** @var Post $post */
        $post = $this->getForm()->getData();
        $timezone = new \DateTimeZone('Indian/Antananarivo');
        $post->setCreatedAt(new \DateTimeImmutable(timezone: $timezone));
        $entityManager->persist($post);
        $entityManager->flush();

        $this->addFlash('success', 'Post saved!');

        return $this->redirectToRoute('app_post_show', [
            'id' => $post->getId(),
        ]);
    }

    #[LiveListener('titleChanged')]
    public function createSlug(#[LiveArg()] string $slug)
    {
        $this->formValues['slug'] = $slug;
    }

    #[LiveAction]
    public function addComment()
    {
        // "formValues" represents the current data in the form
        // this modifies the form to add an extra comment
        // the result: another embedded comment form!
        // change "comments" to the name of the field that uses CollectionType
        $this->formValues['comments'][] = [];
    }

    #[LiveAction]
    public function removeComment(#[LiveArg] int $index)
    {
        unset($this->formValues['comments'][$index]);
    }
    
}
