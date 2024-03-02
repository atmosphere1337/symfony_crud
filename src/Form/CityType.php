<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['type'] == 'update')
        {  
            $builder
                ->setMethod("POST")
                ->setAction('/city/page')
                ->add('id', IntegerType::class)
                ->add('city', TextType::class)
                ->add('country', TextType::class)
                ->add('population', IntegerType::class)
                ->add('update', SubmitType::class)
            ;
        }
        else if ($options['type'] == 'drop')
        {
            $builder
                ->setMethod("POST")
                ->setAction('/city/page')
                ->add('id', IntegerType::class)
                ->add('delete', SubmitType::class)
            ;
        }
        else // if ($options['type'] == 'create') 
        {            
            $builder
                ->setMethod("POST")
                ->setAction('/city/page')
                ->add('city', TextType::class)
                ->add('country', TextType::class)
                ->add('population', IntegerType::class)
                ->add('save', SubmitType::class)
            ;            
        }
    }    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => City::class,
            'type' => 'create',
        ]);
    }
}
