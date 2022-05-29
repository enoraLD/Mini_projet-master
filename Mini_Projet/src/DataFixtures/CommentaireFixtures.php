<?php

namespace App\DataFixtures;

use App\Entity\Commentaire;
use Doctrine\Persistence\ObjectManager;

class CommentaireFixtures
{
    public function load(ObjectManager $manager): void
    {

        $commentaire = new Commentaire();
        $commentaire->setCrypto(1);
        $commentaire->setDate(new \DateTime());
        $commentaire->setTexte("crypto génial je recommande");
        $commentaire->setUser(1);
        $manager->persist($commentaire);

        $commentaire2 = new Commentaire();
        $commentaire2->setCrypto(1);
        $commentaire2->setDate(new \DateTime());
        $commentaire2->setTexte("je recommande");
        $commentaire2->setUser(2);
        $manager->persist($commentaire2);

        $commentaire3 = new Commentaire();
        $commentaire3->setCrypto(1);
        $commentaire3->setDate(new \DateTime());
        $commentaire3->setTexte("bon investissement");
        $commentaire3->setUser(3);
        $manager->persist($commentaire3);

        $manager->flush();
    }
}