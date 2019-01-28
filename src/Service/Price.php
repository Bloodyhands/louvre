<?php

namespace App\Service;

use App\Entity\Ticket;

class Price
{
	/**
	 * On récupère l'âge des personnes de chaque billet
	 *
	 * @param \DateTime $birthdate
	 */
	public function calculatePrice(Ticket $ticket)
	{
		if ($ticket->getReducePrice()) {
			return Ticket::REDUCE;
		}

		$datetime1 = new \DateTime('now');
		$age = $datetime1->diff($ticket->getBirthdayDate())->y;

		switch ($age) {
			case ($age >= 60):
				return Ticket::SENIOR;
			case ($age >= 13):
				return Ticket::NORMAL;
			case ($age >= 4):
				return Ticket::CHILDREN;
			default:
				return 0;
		}
	}
}