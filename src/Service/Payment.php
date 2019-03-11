<?php

namespace App\Service;

use App\Entity\Booking;

class Payment
{
	/**
	 * Création de charge et de customer pour stripe
	 *
	 * @param Booking $booking
	 */
	public function Stripe(Booking $booking)
	{
		\Stripe\Stripe::setApiKey("sk_test_R7GKNPglrU42KXLwFlnOLX2X");

		$token  =$_POST['stripeToken'];
		$charge = \Stripe\Charge::create([
			'amount' => ($booking->getTotalPrice()) * 100,
			'currency' => 'eur',
			'source' => $token
										 ]);

		/*$customer = \Stripe\Customer::create([
			'email' => $booking->getEmail(),
			'source' => 'src_18eYalAHEMiOZZp1l9ZTjSU'
											 ]);*/
	}
}