<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Distributeurs;
use App\Entity\Produits;
use App\Entity\References;
use App\Form\ReferencesType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('reference', ReferencesType::class, [
                'label'=>'votre référence'
            ])
//            ->add('categorie', EntityType::class, [
//                'class' => Categories::class,
//                'choice_label' => 'nom',
//            ])
            ->add('distributeur', EntityType::class, [
                'class' => Distributeurs::class,
                'choice_label' => 'nom',
                'multiple' => true,
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
