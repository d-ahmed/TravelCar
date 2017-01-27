<?php

namespace TravelCarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use TravelCarBundle\Form\VehicleType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('departureDate', TextType::class)
                ->add('travelTime', TextType::class)
                ->add('departureCity', TextType::class)
                ->add('cityOfArrival', TextType::class)
                ->add('pricePerPersonne', MoneyType::class)
                ->add('numberOfPlace', IntegerType::class)
                ->add('vehicle', VehicleType::class)
                ;
                
        
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
