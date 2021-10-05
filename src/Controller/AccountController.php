<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/account/edit", name="app_account_edit")
     */
    public function edit(Request $req,EntityManagerInterface $em): Response
    {
        $user=$this->getUser();
        $form = $this->createForm(UserFormType::class,$user);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
             $em->flush();
             $this->addFlash('success','Profile updated successfully');
             return $this->redirectToRoute('app_account');
        }
        return $this->renderForm('account/edit.html.twig', [
            'controller_name' => 'AccountController',
            'form' => $form,
        ]);
    }
}
