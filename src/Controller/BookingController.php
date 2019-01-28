<?php

namespace App\Controller;

use App\Form\BookingType;
use App\Service\Price;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Booking;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;


class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking")
     */
    public function reservations(Request $request, ObjectManager $manager, Price $price)//fonction d'accès et de création des réservations
    {
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			foreach ($booking->getTickets() as $ticket) {

				$ticket->setBooking($booking);
				$booking->addTicket($ticket);
				$ticket->setPrice($price->calculatePrice($ticket));
				$manager->persist($ticket);
			}die();

			$manager->persist($booking);
			$manager->flush();
		}
		return $this->render('booking/booking.html.twig', array(
			'form' => $form->createView()
		));
    }
}
