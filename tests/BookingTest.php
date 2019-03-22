<?php

use App\Entity\Booking;
use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
	/**
	 * Vérifie que cet email sera accepté
	 */
	public function testCorrectMail()
	{
		$mail = "mathieu_franon@outlook.fr";
		$booking = new Booking();
		$booking->setEmail($mail);
		$this->assertEquals($mail, $booking->getEmail());
	}
}