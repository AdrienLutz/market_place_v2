<?php

namespace App\Form;

//use App\Entity\Categories;
//use App\Entity\Distributeurs;
//use App\Entity\Produits;
//use App\Entity\References;
//use App\Form\ReferencesType;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Produits;
use App\Entity\Categories;
use App\Entity\Distributeurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
//            ->add('distributeur', EntityType::class, [
//                'class' => Distributeurs::class,
//                'choice_label' => 'nom',
//                'multiple' => true,
//            ])

            ->add('distributeur', EntityType::class,[//Champ de type Entité
                'class' => Distributeurs::class,//Appel de l'entité src/Entity/Distributeurs.php
                'multiple' => true,//Autorise plusieur entrées
                'choice_label' => 'nom',//Le champ de l'entité References à afficher
                'expanded' => true,//Autorise la sélection de plusieurs entrées
            ])
            ->add('categorie', EntityType::class,[//Champ de type Entité
                'label' => 'Catégorie du produit',
                'class' => Categories::class,//Appel de l'entité src/Entity/Categories.php
                'choice_label' => 'nom'//Le champ de l'entité References à afficher
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
