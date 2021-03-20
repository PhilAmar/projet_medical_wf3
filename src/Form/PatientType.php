<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('taille')
            ->add('poids')
            ->add('pression')
            ->add('civilite',
                ChoiceType::class,
                [
                    'label'=>'Civilité',
                    'choices'=> [
                        'Monsieur'=>'Monsieur',
                        'Madame'=>'Madame'
                    ],
                    'placeholder' => 'Séléctionnez la civilité'
                ]
            )
            ->add('date_naissance', BirthdayType::class, ['widget' => 'single_text'])
            ->add('email')
            ->add('telephone')
            ->add('secu')
            ->add('antecedents')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
