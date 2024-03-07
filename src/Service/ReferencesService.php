<?php
// src/Service/ReferencesService.php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\References;

class ReferencesService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Ajoutez des méthodes pour interagir avec l'entité References
    public function createReference(string $nom): References
    {
        $reference = new References();
        $reference->setNom($nom);

        $this->entityManager->persist($reference);
//        $this->entityManager->flush();

        return $reference;
    }
    public function saveReference(References $reference): void
    {
        $this->entityManager->persist($reference);
        $this->entityManager->flush();
    }
}

?>