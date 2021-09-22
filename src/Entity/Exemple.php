<?php

namespace App\Entity;

use App\Repository\ExempleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExempleRepository::class)
 */
class Exemple
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $creatAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatAt(): ?\DateTimeImmutable
    {
        return $this->creatAt;
    }

    public function setCreatAt(?\DateTimeImmutable $creatAt): self
    {
        $this->creatAt = $creatAt;

        return $this;
    }
}
