<?php

namespace App\Domain\Concession\Form\Type;


use App\Domain\Concession\Entity\Concession;
use App\Domain\User\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcessionType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'app.concession.name'
            ])
            ->add('city', ChoiceType::class, [
                'choices' => [
                    'Orléans' => 'Orléans',
                    'Tours' => 'Tours',
                    'Paris' => 'Paris',
                    'Chateauroux' => 'Chateauroux',
                    'Dreux' => 'Dreux',
                    'Mainvilliers' => 'Mainvilliers',
                    'Versailles' => 'Versailles',
                    'Evreux' => 'Evreux',
                    'Blois' => 'Blois'

                ],
                'required' => false,
                'label' => 'app.concession.city'
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOption(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'dataClass' => Concession::class
        ]);
    }
}