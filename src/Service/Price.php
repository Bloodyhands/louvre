<?php

namespace App\Service;

use App\Entity\Ticket;
use App\Entity\Booking;

class Price
{
	/**
	 * On récupère l'âge des personnes de chaque billet pour leur attirbuer un tarif
	 *
	 * @param Ticket $ticket
	 */
	public function calculatePrice(Ticket $ticket)
	{
		if ($ticket->getReducePrice()) {
			return Ticket::REDUCE;
		}

		$datetime1 = new \DateTime('now');
		$age = $datetime1->diff($ticket->getBirthdayDate())->y;
		switch ($age) {
			case ($age < 4):
				return 0;
			case ($age >= 60):
				return Ticket::SENIOR;
			case ($age >= 13):
				return Ticket::NORMAL;
			case ($age >= 4):
				return Ticket::CHILDREN;
		}
	}

	/**
	 * On récupère le prix total des billets pour la réservation
	 *
	 * @param Booking $booking
	 */
	public function calculateTotalPrice(Booking $booking)
	{
		$total = 0;
		foreach ($booking->getTickets() as $ticket) {
			$total += $this->calculatePrice($ticket);
		}

		if ($booking->getDayType() == true) {
			$total = $total / 2;
		}

		return $total;
	}
}