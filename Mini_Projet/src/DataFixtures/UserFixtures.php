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
        $user->setUsername("user1");
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'user1'));
        $user->setRoles(array('ROLE_USER'));
        $manager->persist($user);

        $user2 = new User();
        $user2->setUsername("admin");
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, 'admin'));
        $user2->setRoles(array('ROLE_ADMIN','ROLE_USER'));
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername("user3");
        $user3->setPassword($this->passwordEncoder->encodePassword($user, 'user3'));
        $user3->setRoles(array('ROLE_USER'));
        $manager->persist($user3);

        $manager->flush();
    }
}