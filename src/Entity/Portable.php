<?php

namespace App\Entity;

use App\Repository\PortableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Appel::class, mappedBy="portable")
     */
    private $appels;

    public function __construct()
    {
        $this->appels = new ArrayCollection();
    }

  

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

    /**
     * @return Collection|Appel[]
     */
    public function getAppels(): Collection
    {
        return $this->appels;
    }

    public function addAppel(Appel $appel): self
    {
        if (!$this->appels->contains($appel)) {
            $this->appels[] = $appel;
            $appel->setPortable($this);
        }

        return $this;
    }

    public function removeAppel(Appel $appel): self
    {
        if ($this->appels->removeElement($appel)) {
            // set the owning side to null (unless already changed)
            if ($appel->getPortable() === $this) {
                $appel->setPortable(null);
            }
        }

        return $this;
    }

   

    

}
