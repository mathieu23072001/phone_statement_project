<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity=Numero::class, inversedBy="personne", cascade={"persist", "remove"})
     */
    private $numero;

    /**
     * @ORM\OneToMany(targetEntity=Portable::class, mappedBy="personne")
     */
    private $portables;

    /**
     * @ORM\OneToMany(targetEntity=Appel::class, mappedBy="peronneOne")
     */
    private $appelsOne;

    /**
     * @ORM\OneToMany(targetEntity=Appel::class, mappedBy="personneTwo")
     */
    private $appelsTwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @ORM\OneToMany(targetEntity=Cas::class, mappedBy="personne",cascade={"persist"})
     */
    private $cas;

    
    public function __construct()
    {
        $this->portables = new ArrayCollection();
        $this->appelsOne = new ArrayCollection();
        $this->appelsTwo = new ArrayCollection();
        $this->cas = new ArrayCollection();
        
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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumero(): ?Numero
    {
        return $this->numero;
    }

    public function setNumero(?Numero $numero): self
    {
        $this->numero = $numero;

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
            $portable->setPersonne($this);
        }

        return $this;
    }

    public function removePortable(Portable $portable): self
    {
        if ($this->portables->removeElement($portable)) {
            // set the owning side to null (unless already changed)
            if ($portable->getPersonne() === $this) {
                $portable->setPersonne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Appel[]
     */
    public function getAppelsOne(): Collection
    {
        return $this->appelsOne;
    }

    public function addAppelsOne(Appel $appelsOne): self
    {
        if (!$this->appelsOne->contains($appelsOne)) {
            $this->appelsOne[] = $appelsOne;
            $appelsOne->setPeronneOne($this);
        }

        return $this;
    }

    public function removeAppelsOne(Appel $appelsOne): self
    {
        if ($this->appelsOne->removeElement($appelsOne)) {
            // set the owning side to null (unless already changed)
            if ($appelsOne->getPeronneOne() === $this) {
                $appelsOne->setPeronneOne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Appel[]
     */
    public function getAppelsTwo(): Collection
    {
        return $this->appelsTwo;
    }

    public function addAppelsTwo(Appel $appelsTwo): self
    {
        if (!$this->appelsTwo->contains($appelsTwo)) {
            $this->appelsTwo[] = $appelsTwo;
            $appelsTwo->setPersonneTwo($this);
        }

        return $this;
    }

    public function removeAppelsTwo(Appel $appelsTwo): self
    {
        if ($this->appelsTwo->removeElement($appelsTwo)) {
            // set the owning side to null (unless already changed)
            if ($appelsTwo->getPersonneTwo() === $this) {
                $appelsTwo->setPersonneTwo(null);
            }
        }

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection|Cas[]
     */
    public function getCas(): Collection
    {
        return $this->cas;
    }

    public function addCa(Cas $ca): self
    {
        if (!$this->cas->contains($ca)) {
            $this->cas[] = $ca;
            $ca->setPersonne($this);
        }

        return $this;
    }

    public function removeCa(Cas $ca): self
    {
        if ($this->cas->removeElement($ca)) {
            // set the owning side to null (unless already changed)
            if ($ca->getPersonne() === $this) {
                $ca->setPersonne(null);
            }
        }

        return $this;
    }

    

   

}
