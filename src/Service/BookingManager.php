<?php

namespace App\Service;

use App\Entity\Booking;
use App\Service\Price;
use App\Service\RandomString;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class BookingManager
{
	public function __construct(ObjectManager $manager, Price $price, RandomString $randomString)
	{
		$this->price = $price;
		$this->randomString = $randomString;
		$this->manager = $manager;
	}

	public function persistTickets(Booking $booking)
	{
		$createdAt = new \DateTime();

		foreach ($booking->getTickets() as $ticket) {
			$ticket->setBooking($booking);
			$booking->addTicket($ticket);
			$ticket->setPrice($this->price->calculatePrice($ticket));
			$booking->setTotalPrice($this->price->calculateTotalPrice($booking));
			$booking->getCreatedAt($createdAt);
			$booking->setReservationNumber($this->randomString->generateRandomString(8));
			$this->manager->persist($ticket);
		}
	}
}