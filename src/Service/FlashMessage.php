<?php

namespace App\Service;

use App\Entity\Booking;
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
		$reservationDate = $booking->getReservationDate();
		$repo = $this->manager->getRepository(Booking::class)->countTicketsByDay($reservationDate);

		if ($repo > Booking::TOTAL_TICKETS_DAY){
			$this->addFlash(
				'alert',
				"Le nombre de tickets possible pour cette journée est dépassé, veuillez choisir une autre date de réservation !"
			);

			return true;
		}

		return false;
	}
}