<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Booking;


class BookingController extends AbstractController
{
    /**
     * @Route("/reservations", name="reservations")
     */
    public function index()
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    /**
     * @Route("/booking", name="booking")
     */
    public function reservations(Request $request, ObjectManager $manager)//fonction d'accès et de création des réservations
    {

    }

}
