<?php

namespace App\Repository;

use App\Entity\Produits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
//use http\Client\Response;

/**
 * @extends ServiceEntityRepository<Produits>
 *
 * @method Produits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produits[]    findAll()
 * @method Produits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produits::class);
    }

    /**
     * @param $ategoryID
     * @return mixed
     */



      public function getAllProductsByIdDescDQL (){
          $produits = $this-> getEntityManager()
              ->createQuery("SELECT p FROM App\Entity\Produits p ORDER BY p.id DESC")
              ->getResult();
              return $produits;
      }


//    public function produitsByCategorie($categorieID)
//    {
//        return$this->createQueryBuilder("p")
//            ->andWhere('p.categorie' = :categorie_id')
//            ->setParameter('categorie_id', $categorieID')
//            -> getQuery()
//            ->getResult();
//    }
//
//
//    public function produitsByDistributeur($distributeurID)
//    {
//        return$this->createQueryBuilder("p")
//            ->innerJoin("p.distributeur", "ditributeur")
//            ->andWhere('p.distributeur.id' = :distributeurID')
//            ->setParameter('distributeur_id', $distributeurID')
//            -> getQuery()
//        ->getResult();
//    }


    //    /**
    //     * @return Produits[] Returns an array of Produits objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Produits
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
