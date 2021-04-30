<?php

namespace  App\Domain\User\Form\Type;

use App\Domain\User\Form\Command\SearchUserCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchUserType extends AbstractType
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
            'data_class' => SearchUserCommand::class,
            'method' => 'GET'
        ]);
    }
}