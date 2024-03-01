<?php

namespace App\Form;

use App\Entity\Calendrier;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendrierType extends AbstractType
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre_calendrier', TextType::class, [
            'label' => 'Titre de l\'événement', // Définit le texte affiché à l'utilisateur
            'required' => true, // Indique que ce champ doit être rempli pour soumettre le formulaire
        ])
        ->add('debut_calendrier', DateTimeType::class, [
            'label' => 'Début de l\'événement',
            'date_widget' => 'single_text',
            'required' => true,
        ])
        ->add('fin_calendrier', DateTimeType::class, [
            'label' => 'Fin de l\'événement',
            'date_widget' => 'single_text',
            'required' => true,
        ])
        ->add('description_calendrier', TextType::class, [
            'label' => 'Description',
            'required' => false, // Optionnel selon votre logique d'application
        ])
        ->add('couleur_fond_calendrier', ColorType::class, [
            'label' => 'Couleur de fond',
            'required' => true,
        ])
        ->add('couleur_bordure_calendrier', ColorType::class, [
            'label' => 'Couleur de la bordure',
            'required' => true,
        ])
        ->add('couleur_texte_calendrier', ColorType::class, [
            'label' => 'Couleur du texte',
            'required' => true,
        ])
        ->add('places_disponibles_calendrier', IntegerType::class, [
            'label' => 'Places disponibles',
            'required' => true,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calendrier::class,
        ]);
    }
}
