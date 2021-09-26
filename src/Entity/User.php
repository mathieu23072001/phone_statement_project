<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true,nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json",nullable=true)
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Membre::class, mappedBy="user")
     */
    private $membres;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Commissaire::class, mappedBy="user")
     */
    private $commissaires;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $active;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->commissaires = new ArrayCollection();
    }

   
    


  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

     /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Membre[]
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
            $membre->setUser($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getUser() === $this) {
                $membre->setUser(null);
            }
        }

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Commissaire[]
     */
    public function getCommissaires(): Collection
    {
        return $this->commissaires;
    }

    public function addCommissaire(Commissaire $commissaire): self
    {
        if (!$this->commissaires->contains($commissaire)) {
            $this->commissaires[] = $commissaire;
            $commissaire->setUser($this);
        }

        return $this;
    }

    public function removeCommissaire(Commissaire $commissaire): self
    {
        if ($this->commissaires->removeElement($commissaire)) {
            // set the owning side to null (unless already changed)
            if ($commissaire->getUser() === $this) {
                $commissaire->setUser(null);
            }
        }

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): self
    {
        $this->active = $active;

        return $this;
    }

    
   

    
    

   

    

   
   
}
