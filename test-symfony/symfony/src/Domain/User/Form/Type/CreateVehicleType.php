<?php


namespace App\Domain\User\Form\Type;

use App\Domain\User\Entity\Vehicle;
use App\Domain\VehicleModel\Entity\VehicleModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateVehicleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', ChoiceType::class, [
                'choices' => [
                    'Red' => 'Red',
                    'Blue' => 'Blue',
                    'Yellow' => 'Yellow',
                    'Grey' => 'Grey',
                    'Black' => 'Black',
                    'White' => 'White',
                    'Purple' => 'Purple',

                ],
                'label' => 'app.user.vehicle_color',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('vehicleModel', EntityType::class, [
                // looks for choices from this entity
                'class' => VehicleModel::class,

                'choice_label' => function(VehicleModel $vehicleModel){
                    return $vehicleModel->getBrand().' '.$vehicleModel->getName();
                },
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class
        ]);
    }
}