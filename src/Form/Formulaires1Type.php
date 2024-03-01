<?php

namespace App\Form;

use App\Entity\Formulaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Formulaires1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_formulaire')
            ->add('prenom_formulaire')
            ->add('telephone_formulaire')
            ->add('email_formulaire')
            ->add('numero_rue_formulaire')
            ->add('rue_formulaire')
            ->add('code_postal_formulaire')
            ->add('ville_formulaire')
            ->add('pays_formulaire')
            ->add('nombre_participants_formulaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formulaires::class,
        ]);
    }
}
