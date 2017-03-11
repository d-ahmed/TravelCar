<?php

namespace TravelCarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StyleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('style', ChoiceType::class, array(
            'choices'=>array(
                'label.default'=>'default',
                'label.classic'=>'classic'
            )
        ))->add('font', ChoiceType::class, array(
            'choices'=>array(
                'label.default'=>'default',
                'label.time_new_roman'=>'time_new_roman'
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $this->getParent();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'travelcarbundle_style';
    }
}
