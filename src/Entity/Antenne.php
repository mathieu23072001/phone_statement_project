<?php

namespace App\Entity;

use App\Repository\AntenneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AntenneRepository::class)
 */
class Antenne
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
     * @ORM\OneToMany(targetEntity=Portable::class, mappedBy="antenne")
     */
    private $portables;

    public function __construct()
    {
        $this->portables = new ArrayCollection();
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
     * @return Collection|Portable[]
     */
    public function getPortables(): Collection
    {
        return $this->portables;
    }

    public function addPortable(Portable $portable): self
    {
        if (!$this->portables->contains($portable)) {
            $this->portables[] = $portable;
            $portable->setAntenne($this);
        }

        return $this;
    }

    public function removePortable(Portable $portable): self
    {
        if ($this->portables->removeElement($portable)) {
            // set the owning side to null (unless already changed)
            if ($portable->getAntenne() === $this) {
                $portable->setAntenne(null);
            }
        }

        return $this;
    }
}
