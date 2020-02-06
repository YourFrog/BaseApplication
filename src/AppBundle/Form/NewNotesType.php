<?php

namespace AppBundle\Form;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 *  Stworzenie nowych notatek
 *
 * @package AppBundle\Form
 */
class NewNotesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('name', TextType::class, [
            'label' => ' ',
            'attr' => [
                'placeholder' => 'Nazwa notatki, potwierdź enterem'
            ]
        ]);
//        $builder->add('submit', SubmitType::class);
    }
}