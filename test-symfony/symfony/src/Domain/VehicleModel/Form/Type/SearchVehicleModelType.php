<?php

namespace App\Domain\VehicleModel\Form\Type;

use App\Domain\VehicleModel\Entity\VehicleModel;
use App\Domain\VehicleModel\Form\Command\SearchVehicleModelCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchVehicleModelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', ChoiceType::class, [
                'choices' => [
                    'Renault' => 'Renault',
                    'Peugeot' => 'Peugeot',
                    'Fiat' => 'Fiat',
                    'Kia' => 'Kia'
                ],
                'required' => false,
                'label' => 'app.vehicle_model.brand'
            ])
            ->add('name', TextType::class, [
                'label' => 'app.vehicle_model.name'
            ]);

    }

    public function getBlockPrefix()
    {
        return null;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchVehicleModelCommand::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}