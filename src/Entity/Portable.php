<?php

namespace App\Entity;

use App\Repository\PortableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PortableRepository::class)
 */
class Portable
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
    private $imei;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imsi;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="portables")
     */
    private $personne;

    /**
     * @ORM\ManyToOne(targetEntity=Antenne::class, inversedBy="portables")
     */
    private $antenne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImei(): ?string
    {
        return $this->imei;
    }

    public function setImei(?string $imei): self
    {
        $this->imei = $imei;

        return $this;
    }

    public function getImsi(): ?string
    {
        return $this->imsi;
    }

    public function setImsi(?string $imsi): self
    {
        $this->imsi = $imsi;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getAntenne(): ?Antenne
    {
        return $this->antenne;
    }

    public function setAntenne(?Antenne $antenne): self
    {
        $this->antenne = $antenne;

        return $this;
    }
}
