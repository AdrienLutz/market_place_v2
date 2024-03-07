<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $User = new User();
        $User->setEmail("user@user.fr");
        $User->setUsername("User");
        $User->setRoles(["ROLE_USER"]);
        $encodedPassword = $this->hasher->hashPassword($User, "user");
        $User->setPassword($encodedPassword);

        $manager->persist($User);

        $Admin = new User();
        $Admin->setEmail("admin@admin.fr");
        $Admin->setUsername("Admin");
        $Admin->setRoles(["ROLE_ADMIN"]);
        $encodedPassword = $this->hasher->hashPassword($Admin, "admin");
        $Admin->setPassword($encodedPassword);

        $manager->persist($Admin);

        $manager->flush();
    }

}