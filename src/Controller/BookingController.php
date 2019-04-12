<?php

namespace App\Controller;

use App\Form\BookingType;
use App\Service\BookingManager;
use App\Service\FlashMessage;
use App\Service\Price;
use App\Service\StripeHandler;
use App\Service\SendEmail;
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
	 * Accès et création des réservations
	 *
	 * @Route("/booking", name="booking")
	 *
	 * @param Request $request
	 * @param ObjectManager $manager
	 * @param Price $price
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
	 * @throws \Exception
	 */
	public function reservations(Request $request, ObjectManager $manager, Price $price, BookingManager $bookingManager, FlashMessage $flashMessage)
	{
		$booking = new Booking();

		$form = $this->createForm(BookingType::class, $booking);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			if ($flashMessage->messageForThousandTickets($booking) == true) {
				return $this->redirectToRoute('booking');
			}

			$bookingManager->persistTickets($booking);
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
