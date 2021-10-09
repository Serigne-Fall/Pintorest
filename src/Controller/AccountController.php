<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserFormType;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account",methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/account/edit", name="app_account_edit",methods={"GET","POST"})
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

    
    /**
     * @Route("/account/change-password", name="app_account_change_password",methods={"GET","POST"})
     */
    public function change(Request $req,EntityManagerInterface $em,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user=$this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $user->setPassword(
                $passwordEncoder->encodePassword($user,$form['newPassword']->getData())
            );
             $em->flush();
             $this->addFlash('success','Password changed SuccessFully');
             return $this->redirectToRoute('app_account');
        }
        

        return $this->renderForm('account/change.html.twig', [
            'controller_name' => 'AccountController',
            'formEdit' => $form,
        ]);
    }
}
