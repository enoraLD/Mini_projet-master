<?php

namespace App\Controller;

use App\Entity\Crypto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    * @Route("/add", name="add")
    */
    public function show():Response
    {
        return new Response('<h1>A faire<\h1>');
    }



}
