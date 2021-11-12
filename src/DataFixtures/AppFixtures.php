<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Operateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
     }
    public function load(ObjectManager $manager)
    {
         $user = new User();
         $operateur1 = new Operateur();
         $operateur2 = new Operateur();
         $operateur1->setNom("Togocom");
         $operateur2->setNom("Moov");
         $user->setEmail("admino@yopmail.com");
         $user->setRoles(["ROLE_ADMIN"]);
         $user->setType(2);
         $user->setActive(1);
         $user->setPassword($this->passwordEncoder->encodePassword(
                         $user,
                         'admin'
                     ));
         $manager->persist($user);
         $manager->persist($operateur1);
         $manager->persist($operateur2);
         $manager->flush();
    }
}
