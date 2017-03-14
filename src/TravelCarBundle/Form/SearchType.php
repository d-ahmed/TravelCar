<?php

namespace TravelCarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use \Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class SearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('departureDate', DateTimeType::class, array('widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'data' => new \DateTime()))
                ->add('departureCity', TextType::class)
                ->add('cityOfArrival', TextType::class);
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
        return 'search_adverts';
    }
}
