<?php

namespace App\Entity;

use App\Repository\OperateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperateurRepository::class)
 */
class Operateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Numero::class, mappedBy="operateur")
     */
    private $numeros;

    public function __construct()
    {
        $this->numeros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Numero[]
     */
    public function getNumeros(): Collection
    {
        return $this->numeros;
    }

    public function addNumero(Numero $numero): self
    {
        if (!$this->numeros->contains($numero)) {
            $this->numeros[] = $numero;
            $numero->setOperateur($this);
        }

        return $this;
    }

    public function removeNumero(Numero $numero): self
    {
        if ($this->numeros->removeElement($numero)) {
            // set the owning side to null (unless already changed)
            if ($numero->getOperateur() === $this) {
                $numero->setOperateur(null);
            }
        }

        return $this;
    }
}
