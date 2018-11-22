<?php

namespace App\Controller;

use App\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Booking;
use App\Entity\Ticket;
use Doctrine\Common\Persistence\ObjectManager;


class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking")
     */
    public function reservations(Request $request, ObjectManager $manager)//fonction d'accès et de création des réservations
    {
        $booking = new Booking();

        $ticket1 = new Ticket();
        $ticket1->setName('ticket1');
        $booking->getTickets()->add($ticket1);

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			foreach ($booking->getTickets() as $ticket) {
				$ticket->setBooking($booking);
				$manager->persist($ticket);
			}

			$manager->persist($booking);
			$manager->flush();
		}

		return $this->render('booking/booking.html.twig', array(
			'form' => $form->createView()
		));
    }
}
