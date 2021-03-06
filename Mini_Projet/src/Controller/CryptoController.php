<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Crypto;
use App\Form\CommentaireFormType;
use App\Form\FiltreFormType;
use App\Form\RechercheFormType;
use App\Repository\CryptoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CryptoController extends AbstractController
{
    /**
     * @Route("/crypto", name="crypto")
     */
    public function index(): Response
    {
        return $this->render('crypto/index.html.twig', [
            'controller_name' => 'CryptoController',
        ]);
    }

    /**
     * @Route("/afficher", name="afficher")
     */
    public function afficher():Response
    {
        $cryptos = $this->getDoctrine()->getRepository(Crypto::class)->findAll(); 

        return $this->render('crypto/display_crypto.html.twig', [
            'cryptos' => $cryptos
        ]);
    }

        /**
         * @Route("/delete", name="delete")
         */
        public function delete():Response
    {
       return new Response('<h1>Suppression a faire' .$id. '<\h1>');
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function edit():Response
    {
        return new Response('<h1>Edition a faire' .$id. '<\h1>');
    }

    /**
     * @Route("/add", name="add")
     */
    public function add():Response
    {
        return new Response('<h1>Ajout a faire<\h1>');
    }

    /**
    * @Route("/show/{id}", name="add")
    */
    public function show($id):Response
    {
//        $CryptoRepository = New CryptoRepository();
//        $crypto= $CryptoRepository->find($id);
        $crypto= $this->getDoctrine()->getRepository(Crypto::class)->find($id);

        if (!$crypto) {
            throw $this->createNotFoundException(
                "La cryptomonnaie avec l'id = {$id} n'existe pas!"
            );
        }

        $commentaires = $crypto->getCommentaires();

        return $this->render('crypto/show.html.twig', ['crypto' => $crypto, 'commentaires' => $commentaires]);
    }

    /**
     * @Route("/add/favoris/{id}", name="favoris")
     */
    public function addFavoris(Crypto $crypto, EntityManagerInterface $em):Response{
        //$crypto = $this->getDoctrine()->getRepository(Crypto::class)->find($id);
        $user = $this->getUser();
        $user->addCryptoFav($crypto);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/filtre", name="filtre")
     */
    public function filtre(EntityManagerInterface $em, Request $request): Response
    {
        $cryptos = new Crypto();
        $form = $this->createForm(RechercheFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $tab = $form->getData();
            $nom  = $tab['nom'];
            $minP = $tab['prixMin'];
            $maxP = $tab['prixMax'];
            $cat = $tab['categorie'];
            $minNbF = $tab['minNbFollowers'];
            $maxNbF = $tab['maxNbFollowers'];

            $arguments = array();
            if($nom != null){
                $arguments['nom'] = $nom;
            }

            if($cat != null){
                $arguments['categorie'] = $cat;
            }


            $temp = $this->getDoctrine()->getRepository(Crypto::class)->findBy($arguments);

            $cryptos = array();
            $cryptos2 = array();

            if(empty($minP) || empty($maxP)) {
                if ($minP != null) {
                    foreach ($temp as $crypto ) {
                        if ($crypto->getPrix() >= $minP) {
                            $cryptos2[] = $crypto;
                        }
                    }
                }
                if($maxP != null ){
                    foreach ($temp as $crypto ) {
                        if ($crypto->getPrix() <= $maxP) {
                            $cryptos2[] = $crypto;
                        }
                    }
                }
            }

            if(!empty($minP) && !empty($maxP)){
                foreach ($temp as $crypto) {
                    if ($crypto->getPrix() <= $maxP && $crypto->getPrix() >= $minP){
                        $cryptos2[] = $crypto;
                    }
                }
            }


            if (!empty($cryptos2)) {
                if ($minNbF != null && $maxNbF != null) {
                    foreach ($cryptos2 as $c) {
                        if ($c->getNbFollowers() <= $maxNbF && $c->getNbFollowers() >= $minNbF) {
                            $cryptos[] = $c;
                        }
                    }
                } else {
                    $cryptos = $cryptos2;
                }
            }

            if (empty($cryptos2)) {
                if($minNbF !=null && $maxNbF != null){
                    foreach ($temp as $crypto) {
                        if ($crypto->getNbFollowers() <= $maxNbF && $crypto->getNbFollowers() >= $minNbF){
                            $cryptos[] = $crypto;
                        }
                    }
                }
                if ($minNbF != null && empty($maxNbF)) {
                    foreach ($temp as $crypto ) {
                        if ($crypto->getNbFollowers() >= $minNbF) {
                            $cryptos[] = $crypto;
                        }
                    }
                }
                if($maxNbF != null && empty($maxNbF) ){
                    foreach ($temp as $crypto ) {
                        if ($crypto->getNbFollowers() <= $maxP) {
                            $cryptos[] = $crypto;
                        }
                    }
                }
            }

            if($minNbF == null && $maxNbF == null && $maxP == null && $minP == null){
                foreach ($temp as $crypto) {
                    $cryptos[] = $crypto;
                }
            }

            return $this->render('crypto/display_crypto.html.twig', [
                'cryptos' => $cryptos
            ]);
        }

        return $this->render("crypto/filtreForm.html.twig",[
        'RechercheForm' => $form->createView()]);

    }

    /**
     * @Route("/classe", name="classe")
     */
    public function classe(EntityManagerInterface $em, Request $request): Response
    {

        $nbmarket = array();
        $nbCryptos = array();

        $nbmarket[0] = 50000000;
        $nbmarket[1] = 500000000;
        $nbmarket[2] = 1000000000;
        $nbmarket[3] = 1000000000 ;

        for($i =0; $i<4;$i++){
            $nbCryptos[$i] = 0;
        }

        $cryptos = $this->getDoctrine()->getRepository(Crypto::class)->findAll();
        foreach ($cryptos as $crypto){
            if($crypto->getMarketcup() >= 1000000000){
                $nbCryptos[3] ++;
            }
            elseif($crypto->getMarketcup() >= 500000000){
                $nbCryptos[2] ++;
            }
            elseif($crypto->getMarketcup() >= 50000000){
                $nbCryptos[1]++;
            }
            else{
                $nbCryptos[0] ++;
            }
        }


        return $this->render('crypto/marketcup.html.twig', ['classe' => $nbmarket,
            'nb' => $nbCryptos]);
    }

    /**
     * @Route("/affichermarket/{valeur}", name="affichermarket")
     */
    public function affichermarket($valeur): Response
    {
        $cryptos = $this->getDoctrine()->getRepository(Crypto::class)->findAll();

        $cryptos2 = array();


        if($valeur!=3) {
            foreach ($cryptos as $crypto) {
                if($valeur==50000000) {
                    if ($crypto->getMarketcup() < $valeur) {
                        $cryptos2[] = $crypto;
                    }
                }
                elseif ($valeur==500000000){
                    if ($crypto->getMarketcup() < $valeur && $crypto->getMarketcup() >= 50000000) {
                        $cryptos2[] = $crypto;
                    }
                }
                elseif($valeur==1000000000) {
                    if ($crypto->getMarketcup() < $valeur && $crypto->getMarketcup() >= 500000000) {
                        $cryptos2[] = $crypto;
                    }
                }

            }
        }else{
            foreach ($cryptos as $crypto) {
                if ($crypto->getMarketcup() >= 1000000000) {
                    $cryptos2[] = $crypto;
                }

            }
        }

        return $this->render('crypto/display_crypto.html.twig', [
            'cryptos' => $cryptos2
        ]);
    }

}
