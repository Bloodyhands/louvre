<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use App\Entity\Booking;

class StripeHandler
{
	private $loggerInterface;

	public function __construct(LoggerInterface $logger)
	{
		$this->loggerInterface = $logger;
	}

	/**
	 * Récupération des erreurs lors du paiement stripe
	 *
	 * @param Booking $booking
	 * @param LoggerInterface $logger
	 */
	public function checkPayment(Booking $booking)
	{
		try {
			\Stripe\Stripe::setApiKey("sk_test_R7GKNPglrU42KXLwFlnOLX2X");

			$this->createCharge($booking);
			$this->createCustomer($booking);

		} catch (\Stripe\Error\Card $e) {
			$this->loggerInterface->error('an error occured');
		} catch (\Stripe\Error\RateLimit $e) {
			$this->loggerInterface->error('Too many requests made to the API too quickly');
		} catch (\Stripe\Error\InvalidRequest $e) {
			$this->loggerInterface->error('Invalid parameters were supplied to Stripe\'s API');
		} catch (\Stripe\Error\Authentication $e) {
			$this->loggerInterface->error('Authentication with Stripe\'s API failed');
		} catch (\Stripe\Error\ApiConnection $e) {
			$this->loggerInterface->error('Network communication with Stripe failed');
		} catch (\Stripe\Error\Base $e) {
			$this->loggerInterface->error('Display a very generic error to the user, and maybe send yourself an email');
		} catch (\Throwable $e) {
			$this->loggerInterface->error('Something else happened, completely unrelated to Stripe');
		}
	}

	/**
	 * Création de la charge de paiement
	 *
	 * @param Booking $booking
	 */
	public function createCharge(Booking $booking)
	{
		\Stripe\Charge::create([
			'amount' => ($booking->getTotalPrice()) * 100,
			'currency' => 'eur',
			'source' => $_POST['stripeToken']
							   ]);
	}

	/**
	 * Création du customer client
	 *
	 * @param Booking $booking
	 */
	public function createCustomer(Booking $booking)
	{
		\Stripe\Customer::create([
			"email" => $booking->getEmail(),
			"source" => $_POST['stripeToken']
											 ]);
	}
}