<?php

namespace App\Controller;

use App\Entity\Crypto;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
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
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/ajouter_droit/{id}", name="admin")
     */
    public function ajouter_droit(){

    }

    /**
     * @Route("/supprimer_uti/{id}", name="admin")
     */
    public function supprimer_uti($id, EntityManagerInterface $em) : Response
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if (!$user){
            throw $this->createNotFoundException(
                "L'utilisateur avec l'id = {$id} n'existe pas!"
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $users2 = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'users' => $users2
        ]);
    }
}
