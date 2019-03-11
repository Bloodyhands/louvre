<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use App\Entity\Booking;

class Log
{
	/**
	 * Récupération des erreurs lors du paiement stripe
	 *
	 * @param Booking $booking
	 * @param LoggerInterface $logger
	 */
	public function checkPayment(Booking $booking, LoggerInterface $logger)
	{
		try {
			\Stripe\Stripe::setApiKey("sk_test_R7GKNPglrU42KXLwFlnOLX2X");

			$token  =$_POST['stripeToken'];
			$charge = \Stripe\Charge::create([
				'amount' => ($booking->getTotalPrice()) * 100,
				 'currency' => 'eur',
				 'source' => $token
											 ]);
		} catch (\Stripe\Error\Card $e) {
			$logger->error('an error occured');
		} catch (\Stripe\Error\RateLimit $e) {
			$logger->error('Too many requests made to the API too quickly');
		} catch (\Stripe\Error\InvalidRequest $e) {
			$logger->error('Invalid parameters were supplied to Stripe\'s API');
		} catch (\Stripe\Error\Authentication $e) {
			$logger->error('Authentication with Stripe\'s API failed');
		} catch (\Stripe\Error\ApiConnection $e) {
			$logger->error('Network communication with Stripe failed');
		} catch (\Stripe\Error\Base $e) {
			$logger->error('Display a very generic error to the user, and maybe send yourself an email');
		} catch (Exception $e) {
			$logger->error('Something else happened, completely unrelated to Stripe');
		}
	}
}