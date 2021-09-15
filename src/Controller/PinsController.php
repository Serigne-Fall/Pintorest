<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PinRepository;
use App\Entity\Pin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
     * @Route("/pins/create", name="app_pins_create")
     */
    public function create(Request $req,EntityManagerInterface $em):Response
    {
        $pin =new Pin;
        $form= $this->createFormBuilder($pin)
        ->add("title",TextType::class)
        ->add("description",TextareaType::class)
        ->getForm()
        ;
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
     * @Route("/pins//edit/{id<[0-9]+>}", name="app_pins_edit")
     */
    public function edit(Request $req,Pin $pin,EntityManagerInterface $em):Response
    {
        $form= $this->createFormBuilder($pin)
        ->add("title",TextType::class)
        ->add("description",TextareaType::class)
        ->getForm()
        ;
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();

            return $this->redirectToRoute("app_home");
        }
        return $this->render("pins/edit.html.twig",[
            "monFormulaireEdit"=>$form->createView(),
            "pin"=>$pin
        ]);

    }
    /**
     * @Route("/pins/{id<[0-9]+>}", name="app_pins_show")
     */
    public function show(Pin $pin):Response
    {
        return $this->render("pins/show.html.twig",compact("pin"));
    }

}
