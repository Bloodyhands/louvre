<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
	 * Accès à la page d'accueil
	 *
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('/home.html.twig', ['title' => "Bienvenue sur le site du Louvre"]);
    }

    /**
	 * Accès à la page des horaires
	 *
     * @Route("/time", name="time")
     */
    public function time()
    {
        return $this->render('/home.html.twig');
    }

    /**
	 * Accès à la page des tarifs
	 *
     * @Route("/price", name="price")
     */
    public function price()
    {
        return $this->render('/home.html.twig');
    }

	/**
	 * Accès à la page contact
	 *
	 * @Route("/contact", name="contact")
	 */
	public function contact()
	{
		return $this->render('/home.html.twig');
	}
}
