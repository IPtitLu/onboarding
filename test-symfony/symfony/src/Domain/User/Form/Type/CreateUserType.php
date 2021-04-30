<?php

namespace  App\Domain\User\Form\Type;

use App\Domain\Concession\Entity\Concession;
use App\Domain\User\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $userConnected */
        //$userConnected = $options['user'];

        /**$rolesAvailable = array_combine(array_map(function($role) {
            return 'app.user.roles.' . strtolower($role);
        }, $userConnected->getRoles()), $userConnected->getRoles());**/

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
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'app.user.password'],
                'second_options' => ['label' => 'app.user.repeated_password']
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Customer' => 'ROLE_CUSTOMER',
                    'Employer' => 'ROLE_EMPLOYER',
                    'Admin' => 'ROLE_ADMIN',
                    'Super admin' => 'ROLE_SUPER_ADMIN'
            ],
                'required' => true,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('concession', EntityType::class, [
                // looks for choices from this entity
                'class' => Concession::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'name',


            ])
        ;

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'user' => null
        ]);

        //$resolver->setAllowedTypes('user', User::class);
    }
}