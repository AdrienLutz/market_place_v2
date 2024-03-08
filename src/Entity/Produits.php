<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
class Produits implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?References $reference = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Categories $categorie = null;

    #[ORM\ManyToMany(targetEntity: Distributeurs::class, inversedBy: 'produits')]
//    private iterable $distributeur;
//    private ArrayCollection $distributeur;
    private Collection $distributeur;

    public function __construct()
    {
        $this->distributeur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getReference(): ?References
    {
        return $this->reference;
    }

    public function setReference(?References $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Distributeurs>
     */
    public function getDistributeur(): Collection
    {
        return $this->distributeur;
    }

    public function addDistributeur(Distributeurs $distributeur): static
    {
        if (!$this->distributeur->contains($distributeur)) {
            $this->distributeur->add($distributeur);
        }

        return $this;
    }

    public function removeDistributeur(Distributeurs $distributeur): static
    {
        $this->distributeur->removeElement($distributeur);

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'nom' => $this->nom,
            'prix' => $this->prix,
            'categorie'=> $this->categorie->getNom(),
            'reference' => $this->reference->getNom(),
            'distributeur' => $this->distributeur->getKeys('produits')
        ];
    }


}
