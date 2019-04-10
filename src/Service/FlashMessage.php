<?php

namespace App\Service;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FlashMessage extends AbstractController
{
	public function __construct(ObjectManager $manager)
	{
		$this->manager = $manager;
	}

	public function messageForThousandTickets(Booking $booking)
	{
		$totalTicketsByDay = 2;

		$reservationDate = $booking->getReservationDate();
		$repo = $this->manager->getRepository(Booking::class)->countTicketsByDay($reservationDate);

		if ($repo > $totalTicketsByDay){
			$this->addFlash(
				'alert',
				"Le nombre de tickets possible pour cette journée est dépassé, veuillez choisir une autre date de réservation !"
			);
			return $this->redirectToRoute('booking');
		}
	}
}