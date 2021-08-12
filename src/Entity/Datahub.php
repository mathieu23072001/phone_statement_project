<?php

namespace App\Entity;

use App\Repository\DatahubRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DatahubRepository::class)
 */
class Datahub
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
    private $abonne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $appele;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identiteAppele;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $heure;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imsi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imei;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $localisation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAbonne(): ?string
    {
        return $this->abonne;
    }

    public function setAbonne(?string $abonne): self
    {
        $this->abonne = $abonne;

        return $this;
    }

    public function getAppele(): ?string
    {
        return $this->appele;
    }

    public function setAppele(?string $appele): self
    {
        $this->appele = $appele;

        return $this;
    }

    public function getIdentiteAppele(): ?string
    {
        return $this->identiteAppele;
    }

    public function setIdentiteAppele(?string $identiteAppele): self
    {
        $this->identiteAppele = $identiteAppele;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?string
    {
        return $this->heure;
    }

    public function setHeure(?string $heure): self
    {
        $this->heure = $heure;

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

    public function getImsi(): ?string
    {
        return $this->imsi;
    }

    public function setImsi(?string $imsi): self
    {
        $this->imsi = $imsi;

        return $this;
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

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }
}
