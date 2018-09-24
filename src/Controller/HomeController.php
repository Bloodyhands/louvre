<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/ticketing", name="ticketing")
     */
    public function index()
    {
        return $this->render('ticketing/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()//fonction d'accès à la page d'accueil
    {
        return $this->render('ticketing/home.html.twig', ['title' => "Bienvenue sur le site du Louvre"]);
    }
}
