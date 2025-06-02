<?php

namespace App\Twig\Components\User;

use App\Entity\User;
use App\Form\RegistrationForm;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class RegistrationFormComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp()]
    public ?User $initialFormData = null;

    #[LiveProp]
    public int $flow_step = 1;

    #[LiveProp]
    public array $userValues = [];

    public function __construct(
       private EntityManagerInterface $entityManager,
       private UserRepository $userRepository,
    ) {}

    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(RegistrationForm::class, $this->initialFormData, [
            'flow_step' => $this->flow_step,
        ]);
    }

    #[LiveAction]
    public function nextStep()
    {
        $this->submitForm();
        $this->setUserValues();
        ++$this->flow_step;
        $this->submitForm(false);
    }

    #[LiveAction]
    public function previousStep()
    {
        --$this->flow_step;
        $this->submitForm(false);
    }

    private function setUserValues()
    {
        foreach ($this->formValues as $key => $value) {
            $this->userValues[$key] = $value;
        }
    }

    #[LiveAction]
    public function saveForm()
    {
        // Submit the form! If validation fails, an exception is thrown
        // and the component is automatically re-rendered with the errors
        $this->submitForm();

        $this->setUserValues();

        // $user = $this->getForm()->getData();

        dd($this->userValues);
    }
}
