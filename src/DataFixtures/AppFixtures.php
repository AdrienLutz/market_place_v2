<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Produits, App\Entity\References, App\Entity\Distributeurs, App\Entity\Categories;
use Faker;




class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        $produits = [];
        $references = [];
        $distributeurs = [];
        $categories = [];

        for ($i = 0; $i < 10; $i++) {
            $reference = new References();
            $reference->setNom('reference '. mt_rand(1,9999). '/' . $i );
            $references[] = $reference;
            $manager->persist($reference);
        }

        for ($i = 0; $i < 10; $i++) {
            $categorie = new Categories();
            $categorie ->setNom($faker->word);
            $categories[] = $categorie;
            $manager->persist($categorie);
        }

        for ($i = 0; $i < 10; $i++) {
            $distributeur = new Distributeurs();
            $distributeur ->setNom($faker->word);
            $distributeurs[] = $distributeur;
            $manager->persist($distributeur);
        }

        for ($i = 0; $i < 10; $i++) {
            $produit = new Produits();
            $produit->setNom($faker->word);
            $produit->setPrix(mt_rand(1, 10000));
//            $produit->setImage('https://pisum.photos/200');
//            $produit->setSlug($produit->getName());

            for ($c = 0; $c < count($categories); $c++){
                $produit->setCategorie($faker->randomElement($categories));
            }

            for ($d = 0; $d < count($distributeurs); $d++){
                $produit->addDistributeur($faker->randomElement($distributeurs));
            }

            for ($r = 0; $r < count($references); $r++){
                $produit->setReference($references[$i]);
            }

            $produits[] = $produit;
            $manager->persist($produit);
        }

        $manager->flush();
    }
}