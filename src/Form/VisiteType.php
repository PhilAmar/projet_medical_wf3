<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taille',
            IntegerType::class,[
                'required' => false
                ])
            ->add('poids',
            IntegerType::class, [
                'required' => false
                ])
            ->add('pression',
                IntegerType::class,[
                'label' => 'Tension',
                 'required' => false
            ])
            ->add('motifVisite',
            TextareaType::class,[
                'label' => 'Motif de la visite',

                ])
            ->add('traitement',
            TextareaType::class,[
                'label' => 'Traitement prescrit'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
