<?php

namespace  App\Domain\User\Form\Type;

use App\Domain\User\Entity\User;
use App\Domain\User\Entity\Vehicle;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'app.user.first_name'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'app.user.last_name'
            ])
            ->add('email', EmailType::class, [
                'label' => 'app.user.email'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Employé' => 'ROLE_EMPLOYEE',
                    'Admin' => 'ROLE_ADMIN',
                    'Super_admin' => 'ROLE_SUPER_ADMIN'
                ],
                'required' => false,
                'multiple' => true,
                'expanded' => false
            ])
            ->add('vehicles', CollectionType::class, [
                'entry_type' => CreateVehicleType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => [
                    'label' => false
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}