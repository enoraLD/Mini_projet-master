<?php

namespace App\DataFixtures;

use App\Entity\Commentaire;
use Doctrine\Persistence\ObjectManager;

class CommentaireFixtures
{
    public function load(ObjectManager $manager): void
    {
        $commentaire = new Commentaire();

        $commentaire->setCrypto(2719);
        $commentaire->setDate(new \DateTime());
        $commentaire->setTexte("crypto génial je recommande");
        $commentaire->setUser(16);
        $manager->persist($commentaire);
        $manager->flush();
    }
}