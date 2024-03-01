<?php

namespace App\Form;

use App\Entity\Formulaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_formulaire')
            ->add('prenom_formulaire')
            ->add('numero_rue_formulaire')
            ->add('rue_formulaire')
            ->add('code_postal_formulaire')
            ->add('ville_formulaire')
            ->add('pays_formulaire')
            ->add('telephone_formulaire')
            ->add('email_formulaire')
            // ->add('nom_facturation_formulaire', TextType::class, [ // Ajoutez un champ pour le nom de facturation
            //     'label' => 'Nom de facturation', // Libellé du champsymfony
            //     'required' => true, // Rendre le champ obligatoire si nécessaire
            //     'attr' => ['id' => 'billing-name'], 
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formulaires::class,
        ]);
    }
}

