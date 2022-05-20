<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("user");
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
        $user->setRoles(array('ROLE_USER'));
        $manager->persist($user);

        $user2 = new User();
        $user2->setUsername("admin");
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, 'admin'));
        $user2->setRoles(array('ROLE_ADMIN','ROLE_USER'));
        $manager->persist($user2);
        $manager->flush();
    }
}