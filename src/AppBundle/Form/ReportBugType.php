<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *  Formularz raportujący błędy
 *
 * @package AppBundle\Form
 */
class ReportBugType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('subject', EntityType::class, [
            'class' => 'AppBundle:Bug\\Subject',
            'multiple' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('r')
                    ->orderBy('r.priority', 'DESC');
            },
        ]);

        $builder->add('frequency', EntityType::class, [
            'class' => 'AppBundle:Bug\\Frequency',
            'multiple' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('r')
                    ->orderBy('r.priority', 'DESC');
            },
        ]);

        $builder->add('link', Type\TextType::class);
        $builder->add('email', Type\EmailType::class);

        $builder->add('description', Type\TextareaType::class);
        $builder->add('submit', Type\SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => \AppBundle\Entity\Bug\Report::class
        ));
    }
}