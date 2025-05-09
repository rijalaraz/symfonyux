<?php

namespace App\Twig\Components\Post;

use App\Entity\Photo;
use App\Entity\Post;
use App\Form\PostType;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
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

    #[LiveProp]
    public array $multipleUploadFilenames = [];

    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(PostType::class, $this->initialFormData);
    }

    private function processFileUpload(UploadedFile $file): array
    {
        // in a real app, move this file somewhere
        // $file->move(...);

        return [$file->getClientOriginalName(), $file->getSize()];
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger)
    {
        // Submit the form! If validation fails, an exception is thrown
        // and the component is automatically re-rendered with the errors
        $this->submitForm();


        $directory = $this->getParameter('upload_directory');

        $sluggedFilename = [];

        $files = $request->files->all('post');

        foreach ($files['photos'] as $sary) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $sary['url'];

            [$filename, $size] = $this->processFileUpload($uploadedFile);
            $this->multipleUploadFilenames[] = ['filename' => $filename, 'size' => $size];

            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

            $name = $slugger->slug($originalFilename)->toString().'.'.$uploadedFile->guessExtension();

            $sluggedFilename[] = $name;

            $file = $uploadedFile->move($directory, $name);
        }

        /** @var Post $post */
        $post = $this->getForm()->getData();

        foreach ($post->getPhotos() as $key => $photo) {
            $photo->setUrl($sluggedFilename[$key]);
        }

        $timezone = new \DateTimeZone('Indian/Antananarivo');
        $post->setCreatedAt(new \DateTimeImmutable(timezone: $timezone));
        $entityManager->persist($post);
        $entityManager->flush();

        // $this->addFlash('success', 'Post saved!');

        // $this->addFlash('danger', 'Attention erreur!');

        // return $this->redirectToRoute('app_post_show', [
        //     'id' => $post->getId(),
        // ]);
    }

    #[LiveListener('titleChanged')]
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

}
