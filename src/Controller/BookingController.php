<?php

namespace App\Controller;

use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Service\Price;
use App\Service\RandomString;
use App\Service\StripeHandler;
use App\Service\SendEmail;
use App\Service\ThousandTickets;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Booking;
use App\Entity\Ticket;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;


class BookingController extends AbstractController
{
	/**
	 * @Route("/booking", name="booking")
	 */
	public function reservations(Request $request, ObjectManager $manager, Price $price, RandomString $randomString)//fonction d'accès et de création des réservations
	{
		$totalTicketsByDay = 1000;
		$booking = new Booking();
		$createdAt = new \DateTime();

		$form = $this->createForm(BookingType::class, $booking);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){

			$reservationDate = $booking->getReservationDate();
			$repo = $manager->getRepository(Booking::class)->countTicketsByDay($reservationDate);

			if ($repo > $totalTicketsByDay){
				$this->addFlash(
					'alert',
					"Le nombre de tickets possible pour cette journée est dépassé, veuillez choisir une autre date de réservation !"
				);
				return $this->redirectToRoute('booking');
			}


			foreach ($booking->getTickets() as $ticket) {
				$ticket->setBooking($booking);
				$booking->addTicket($ticket);
				$ticket->setPrice($price->calculatePrice($ticket));
				$booking->setTotalPrice($price->calculateTotalPrice($booking));
				$booking->getCreatedAt($createdAt);
				$booking->setReservationNumber($randomString->generateRandomString(8));
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
	 * @param StripeHandler $stripeHandler
	 * @param SendEmail $sendEmail
	 *
	 * @return Response
	 */
	public function successfull(Booking $booking, StripeHandler $stripeHandler, SendEmail $sendEmail)
	{
		$stripeHandler->checkPayment($booking);
		$sendEmail->mail($booking);

		return $this->render('booking/successfull.html.twig', [
			'booking' => $booking
		]);
	}
}
