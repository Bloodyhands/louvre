<?php

use App\Entity\Booking;
use App\Entity\Ticket;
use App\Service\Price;
use App\Service\SendEmail;
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

	/**
	 * @param $reducePrice
	 * @param $birthdate
	 * @param $expected
	 * @throws Exception
	 *
	 * @dataProvider priceProvider
	 */
	public function testPrice($reducePrice, $birthdate, $expected)
	{
		$ticket = new Ticket();
		$price = new Price();
		$ticket->setReducePrice($reducePrice);
		$ticket->setBirthdayDate(new \DateTime($birthdate));
		$this->assertEquals($expected, $price->calculatePrice($ticket));
	}

	/**
	 * Récupération d'un tableau de données pour les tests de prix
	 *
	 * @return array
	 */
	public function priceProvider()
	{
		return [
			[true, '10/10/1986', 10],
			[false, '10/11/1990', 16],
			[false, '05/06/2016', 0],
			[false, '02/25/2012', 8],
			[false, '07/16/1930', 12]
		];
	}

	/**
	 * @group mail
	 * Test d'envoi d'email une seule fois par commande
	 */
	public function testSendEmailOnce()
	{
		$booking = new Booking();
		$booking->setReservationNumber('AbcedPF');
		$booking->setEmail('mathieu_franon@outlook.fr');

		$swiftMailer = $this->getMockBuilder(Swift_Mailer::class)
			->disableOriginalConstructor()
			->setMethods(['send'])
			->getMock();

		$templating = $this->getMockBuilder(Twig_Environment::class)
			->disableOriginalConstructor()
			->setMethods(['render'])
			->getMock();

		$swiftMailer->expects($this->once())
			->method('send');

		$sendEmail = new SendEmail($swiftMailer, $templating);
		$sendEmail->mail($booking);


	}
}