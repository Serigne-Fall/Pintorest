<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PinRepository;
use App\Entity\Pin;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PinType;
class PinsController extends AbstractController
{
    /**
     * @Route("/pins", name="app_home")
     */
public function index(EntityManagerInterface $em,PinRepository $repo): Response
    {
        $pins=$repo->findBy([],['createdAt'=>"DESC"]);
        return $this->render('pins/index.html.twig',compact('pins'));
    }

    /**
     * @Route("/pins/create", name="app_pins_create",methods={"GET","POST"})
     */
    public function create(Request $req,EntityManagerInterface $em):Response
    {
        $pin =new Pin;
        $form= $this->createForm(PinType::class,$pin,['method' => 'POST']);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute("app_home");
        }
        return $this->render("pins/create.html.twig",[
            "monFormulaire"=>$form->createView()
        ]);

    }
    /**
     * @Route("/pins/{id<[0-9]+>}", name="app_pins_show")
     */
    public function show(Pin $pin):Response
    {
        return $this->render("pins/show.html.twig",compact("pin"));
    }


    /**
     * @Route("/pins/edit/{id<[0-9]+>}", name="app_pins_edit",methods={"GET","POST"})
     */
    public function edit(Request $req,Pin $pin,EntityManagerInterface $em):Response
    {
        $form= $this->createForm(PinType::class,$pin,['method' => 'POST']);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();

            return $this->redirectToRoute("app_home");
        }
        return $this->render("pins/edit.html.twig",[
            "monFormulaire"=>$form->createView(),
            "pin"=>$pin
        ]);


    }


    /**
     * @Route("/pins/delete/{id<[0-9]+>}", name="app_pins_delete",methods={"GET","POST","DELETE "})
     */
    public function delete(Request $req,Pin $pin,EntityManagerInterface $em):Response
    {
        if($this->isCsrfTokenValid('pin_deletion_'.$pin->getId(),$req->request->get("csrf_token"))){
            $em->remove($pin);
            $em->flush();
        }
        return $this->redirectToRoute("app_home");
    }

    

}
