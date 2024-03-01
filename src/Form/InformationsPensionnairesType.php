<?php

namespace App\Form;

use App\Entity\InformationsPensionnaires;
use App\Entity\Pensionnaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformationsPensionnairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nourriture_information_pensionnaire')
            ->add('soin_information_pensionnaire')
            ->add('carnet_de_sante_information_pensionnaire')
            ->add('histoire_information_pensionnaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InformationsPensionnaires::class,
        ]);
    }
}
