<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/favs", name="favs")
     */
    public function favs():Response
    {
        $user = $this->getUser();
        $cryptos = $user->getCryptoFav();
        return $this->render('crypto/fav.html.twig', [
            'cryptos' => $cryptos
        ]);
    }

}
