<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PinRepository;

class PinsController extends AbstractController
{
    /**
     * @Route("/pins", name="pins")
     */
    public function index(EntityManagerInterface $em,PinRepository $repo): Response
    {
        $pins=$repo->findAll(Pin::class);
        return $this->render('pins/index.html.twig',compact('pins'));
    }
}
