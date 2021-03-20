<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomUtilisateur',
            TextType::class,
                [
                    'label' => 'Nom d\'utilisateur'
                ]
            )
            ->add('nomComplet',
            TextType::class,
                [
                    'label' => 'Nom complet'
                ]
            )
            ->add('fonction',
                ChoiceType::class,
                [
                    'label' => 'Fonction',
                    'choices' => [
                        'Docteur' => 'Docteur',
                        'Assistant médical' => 'Assistant médical',
                        'Secrétaire médical' => 'Secrétaire médical',
                        'Stagiaire' => 'Stagiaire'
                    ],
                    'placeholder' => 'Séléctionnez une fonction'
                ]
            )
            ->add('telephone',
                TextType::class,
                [
                    'label' => 'Numéro de téléphone'
                ]
            )
            ->add('plainMdp',
            RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Mot de passe',
                        'help' => 'Le mot de passe ne doit contenir que des lettres, des chiffres'
                            . ' et faire entre 6 et 20 caractères'
                    ],
                    'second_options' => [
                        'label' => 'Confirmez le mot de passe'
                    ],
                    'invalid_message' => 'La confirmation ne correspond pas au mot de passe'
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
