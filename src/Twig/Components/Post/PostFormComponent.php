<?php

namespace App\Twig\Components\Post;

use App\Entity\Photo;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    public function __construct(
       private EntityManagerInterface $entityManager,
       private PhotoRepository $photoRepository,
    ) {}

    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(PostType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function save(Request $request)
    {
        // Submit the form! If validation fails, an exception is thrown
        // and the component is automatically re-rendered with the errors
        $this->submitForm();


        /** @var Post $post */
        $post = $this->getForm()->getData();

        $files = $request->files->all('post');

        if (!empty($files)) {
            foreach ($files['photos'] as $sary) {

                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $sary['imageFile']['file'];

                $photo = new Photo();

                $photo->setImageFile($uploadedFile);

                $post->addPhoto($photo);
            }
        }

        $timezone = new \DateTimeZone('Indian/Antananarivo');
        $post->setCreatedAt(new \DateTimeImmutable(timezone: $timezone));
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        $this->addFlash('success', 'Post saved!');

        return $this->redirectToRoute('app_post_show', [
            'id' => $post->getId(),
        ]);
    }

    #[LiveListener('title:changed')]
    public function createSlug(#[LiveArg()] string $slug)
    {
        $this->formValues['slug'] = $slug;
    }

    #[LiveAction]
    public function addCollectionItem(#[LiveArg] string $name)
    {
        // "formValues" represents the current data in the form
        // this modifies the form to add an extra comment
        // the result: another embedded comment form!
        // change "comments" to the name of the field that uses CollectionType
        switch ($name) {
            case 'post[photos]':
                $this->formValues['photos'][] = [];
                break;

            default:
                $this->formValues['comments'][] = [];    
                break;
        }
    }

    #[LiveAction]
    public function removeCollectionItem(#[LiveArg] int $index, #[LiveArg] string $name)
    {
        switch ($name) {
            case 'post[photos]':
                unset($this->formValues['photos'][$index]);
                break;

            default:
                unset($this->formValues['comments'][$index]);
                break;
        }
    }

    #[LiveAction]
    public function deletePhoto(#[LiveArg()] $id)
    {
        $photo = $this->photoRepository->find($id);
        $this->entityManager->remove($photo);
        $this->entityManager->flush();
    }

    #[LiveListener('meal:changed')]
    public function cleanFoods(#[LiveArg()] string $meal)
    {
        $this->formValues['foods'] = [];
    }
}
