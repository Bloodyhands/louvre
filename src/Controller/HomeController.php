<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/partials", name="partials")
     */
    public function index()
    {
        return $this->render('/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()//fonction d'accès à la page d'accueil
    {
        return $this->render('/home.html.twig', ['title' => "Bienvenue sur le site du Louvre"]);
    }

    /**
     * @Route("/time", name="time")
     */
    public function time() //fonction d'accès à la page horaires
    {
        return $this->render('/home.html.twig');
    }

    /**
     * @Route("/price", name="price")
     */
    public function price() //fonction d'accès à la page tarifs
    {
        return $this->render('/home.html.twig');
    }
}
