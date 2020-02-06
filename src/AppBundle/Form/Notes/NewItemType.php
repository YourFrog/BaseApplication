<?php

namespace AppBundle\Form\Notes;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 *  Stworzenie nowego elementu notatki
 *
 * @package AppBundle\Form
 */
class NewItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('name', TextType::class, [
            'label' => ' ',
            'attr' => [
                'placeholder' => 'Nazwa elementu, potwierdź enterem'
            ]
        ]);
//        $builder->add('submit', SubmitType::class);
    }
}