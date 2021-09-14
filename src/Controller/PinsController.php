<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PinRepository;
use App\Entity\Pin;

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
     * @Route("/pins/{id<[0-9]+>}", name="app_pins_show")
     */
    public function show(Pin $pin):Response
    {
        return $this->render("pins/show.html.twig",compact("pin"));
    }

}
