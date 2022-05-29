<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Crypto;
use App\Entity\User;
use App\Form\CommentaireFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }
    /**
     * @Route("/add/commentaire/{id}", name="commentaire")
     */
    public function addCommentaire(Request $request, EntityManagerInterface $em, $id):Response{
        $comm = new Commentaire();
        $currentUser = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'username' => $this->getUser()->getUsername()
        ]);
        $comm->setUser($currentUser);
        $crypto = $this->getDoctrine()->getRepository(Crypto::Class)->find($id);
        $comm->setCrypto($crypto);
        $comm->setDate(new DateTime('now'));

        $form = $this->createForm(CommentaireFormType::class,$comm);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($comm);
            $currentUser->addCommentaire($comm);
            $crypto->addCommentaire($comm);

            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('commentaire/index.html.twig',[
            'formulaire' => $form->createView()
        ]);


    }
}
