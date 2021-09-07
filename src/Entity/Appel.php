<?php

namespace App\Entity;

use App\Repository\AppelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppelRepository::class)
 */
class Appel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeAppel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sensAppel;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="appelsOne")
     */
    private $peronneOne;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="appelsTwo")
     */
    private $personneTwo;

    /**
     * @ORM\ManyToOne(targetEntity=Portable::class, inversedBy="appels")
     */
    private $portable;

    /**
     * @ORM\ManyToOne(targetEntity=Antenne::class, inversedBy="appels")
     */
    private $antenne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getTypeAppel(): ?string
    {
        return $this->typeAppel;
    }

    public function setTypeAppel(?string $typeAppel): self
    {
        $this->typeAppel = $typeAppel;

        return $this;
    }

    public function getSensAppel(): ?string
    {
        return $this->sensAppel;
    }

    public function setSensAppel(?string $sensAppel): self
    {
        $this->sensAppel = $sensAppel;

        return $this;
    }

    public function getPeronneOne(): ?Personne
    {
        return $this->peronneOne;
    }

    public function setPeronneOne(?Personne $peronneOne): self
    {
        $this->peronneOne = $peronneOne;

        return $this;
    }

    public function getPersonneTwo(): ?Personne
    {
        return $this->personneTwo;
    }

    public function setPersonneTwo(?Personne $personneTwo): self
    {
        $this->personneTwo = $personneTwo;

        return $this;
    }

    public function getPortable(): ?Portable
    {
        return $this->portable;
    }

    public function setPortable(?Portable $portable): self
    {
        $this->portable = $portable;

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
