<?php

namespace  App\Domain\Concession\Form\Type;

use App\Domain\Concession\Form\Command\SearchConcessionCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchConcessionType extends AbstractType
{
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
            'data_class' => SearchConcessionCommand::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}