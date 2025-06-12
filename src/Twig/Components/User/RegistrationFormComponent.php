<?php

namespace App\Twig\Components\User;

use App\Entity\User;
use App\Form\RegistrationForm;
use App\Repository\EtablissementRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsLiveComponent]
final class RegistrationFormComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp()]
    public ?User $initialFormData = null;

    #[LiveProp]
    public int $flow_step = 1;

    public function __construct(
       private EntityManagerInterface $entityManager,
       private UserRepository $userRepository,
       private EtablissementRepository $etablissementRepository,
       private Session $session,
    ) {}

    #[PreMount()]
    public function setFlowStepSession()
    {
        if (!empty($this->session->get('flow_step'))) {
            $this->flow_step = $this->session->get('flow_step');
        } else {
            $this->session->set('flow_step', $this->flow_step);
        }
    }

    public function getFormValuesSession()
    {
        if (!empty($this->session->get('flow_step')) && !empty($this->session->get('formValues'))) {

            $formValues = $this->session->get('formValues');

            if (isset($formValues[$this->session->get('flow_step')])) {
                return $formValues[$this->session->get('flow_step')];
            }

        }
        return [];
    }

    protected function instantiateForm(): FormInterface
    {
        $formValues = $this->getFormValuesSession();

        if (!empty($formValues)) {
            $this->initialFormData = new User();
            switch ($this->session->get('flow_step')) {
                case 1:
                    $this->initialFormData->setPrenom($formValues['prenom']);
                    $this->initialFormData->setCivilite($formValues['civilite']);
                    break;

                case 2:
                    $this->initialFormData->setEmail($formValues['email']);
                    break;

                case 3:
                    $etablissement = $this->etablissementRepository->find($formValues['etablissement']);
                    $this->initialFormData->setEtablissement($etablissement);
                    break;
            }
        }

        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(RegistrationForm::class, $this->initialFormData, [
            'flow_step' => $this->session->get('flow_step'),
        ]);
    }

    #[LiveAction]
    public function nextStep()
    {
        $this->submitForm();

        $this->setFormValuesSession();

        ++$this->flow_step;

        $this->session->set('flow_step', $this->flow_step);

        $this->submitForm(false);
    }

    #[LiveAction]
    public function previousStep()
    {
        --$this->flow_step;

        $this->session->set('flow_step', $this->flow_step);

        $formValues = $this->session->get('formValues');

        $this->formValues = $formValues[$this->flow_step];

        $this->submitForm(false);
    }

    private function setFormValuesSession()
    {
        $formValues[$this->flow_step] = $this->formValues;

        if (!empty($this->session->get('formValues'))) {
            $this->session->set('formValues', array_replace($this->session->get('formValues'), $formValues));    
        } else {
            $this->session->set('formValues', $formValues);
        }
    }

    #[LiveAction]
    public function saveForm()
    {
        // Submit the form! If validation fails, an exception is thrown
        // and the component is automatically re-rendered with the errors
        $this->submitForm();

        $this->setFormValuesSession();

        dd($this->session->get('formValues'));
    }
}
