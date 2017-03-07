<?php

namespace TravelCarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('departureDate', DateTimeType::class, array('widget' => 'single_text', 'format' => 'dd/MM/yyyy H:m', 'data' => new \DateTime()))
                ->add('travelTime', DateTimeType::class, array('widget' => 'single_text', 'format' => 'H:m'))
                ->add('departureCity', TextType::class)
                ->add('cityOfArrival', TextType::class)
                ->add('pricePerPersonne', IntegerType::class)
                ->add('numberOfPlace', IntegerType::class)
                ->add('luggage', ChoiceType::class, array(
                    'choices' => array('Petite'=>'Petite', 'Moyenne'=>'Moyenne', 'Grande'=>'Grande'),
                ))->add('highway', CheckboxType::class, array(
                    'required' => false,
                    'data' => true,
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TravelCarBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'travelcarbundle_advert';
    }
}
