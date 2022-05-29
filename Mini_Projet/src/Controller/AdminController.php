<?php

namespace App\Controller;

use App\Entity\Crypto;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
//    /**
//     * @Route("/admin", name="admin")
//     */
//    public function index(): Response
//    {
//        return $this->render('admin/index.html.twig', [
//            'controller_name' => 'AdminController',
//        ]);
//    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        $cryptos = $this->getDoctrine()->getRepository(Crypto::class)->findAll();

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'cryptos' => $cryptos,
            'users' => $users
        ]);
    }

}
