<?php

namespace App\Controller;

use App\Form\BookingType;
use App\Service\Price;
use App\Service\Log;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Booking;
use App\Entity\Ticket;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\Session;


class BookingController extends AbstractController
{
	/**
	 * @Route("/booking", name="booking")
	 */
	public function reservations(Request $request, ObjectManager $manager, Price $price)//fonction d'accès et de création des réservations
	{
		$booking = new Booking();
		$createdAt = new \DateTime();

		$form = $this->createForm(BookingType::class, $booking);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			foreach ($booking->getTickets() as $ticket) {
				$ticket->setBooking($booking);
				$booking->addTicket($ticket);
				$ticket->setPrice($price->calculatePrice($ticket));
				$booking->setTotalPrice($price->calculateTotalPrice($booking));
				$booking->getCreatedAt($createdAt);
				$manager->persist($ticket);
			}

			$manager->persist($booking);
			$manager->flush();

			return $this->redirectToRoute('summary', ['id' => $booking->getId()]);

		}
		return $this->render('booking/booking.html.twig', array(
			'form' => $form->createView(),
			'total_price' => $price->calculateTotalPrice($booking)
		));
	}

	/**
	 * Permet d'afficher le résumé de la réservation
	 *
	 * @Route("/booking/{id}/summary", name="summary")
	 *
	 * @param Booking $booking
	 *
	 * @return Response
	 */
	public function summary(Booking $booking)
	{
		return $this->render('booking/summary.html.twig', [
			'booking' => $booking
		]);
	}

	/**
	 * Permet d'afficher la validation du paiement de la réservation
	 *
	 * @Route("/booking/{id}/successfull", name="successfull")
	 *
	 * @param Booking $booking
	 * @param Log $log
	 *
	 * @return Response
	 */
	public function successfull(Booking $booking, Log $log, LoggerInterface $logger)
	{
		return $this->render('booking/successfull.html.twig', [
			'booking' => $booking,
			'log' => $log->checkPayment($booking, $logger)
		]);
	}
}
