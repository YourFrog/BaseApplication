<?php

namespace AppBundle\Form;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *  Formularz rejestracyjny
 *
 * @package AppBundle\Form
 */
class RegistrationFormType extends BaseRegistrationFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('submit', SubmitType::class);
    }
}