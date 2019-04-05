<?php

namespace App\Service;

use App\Entity\Booking;
use Swift_Mailer;
use Twig_Environment;

class SendEmail
{
	private $mail;
	private $template;

	public function __construct(Swift_Mailer $mailer, Twig_Environment $templating)
	{
		$this->mail = $mailer;
		$this->template = $templating;
	}

	/**
	 * Envoi d'un email de confirmation de commande
	 *
	 * @param Booking $booking
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @throws \Twig_Error_Loader
	 * @throws \Twig_Error_Runtime
	 * @throws \Twig_Error_Syntax
	 */
	public function mail(Booking $booking)
	{
		$message = (new \Swift_Message('Réservation'.' '.$booking->getReservationNumber()))
			->setFrom('mathieu_franon@outlook.fr')
			->setTo($booking->getEmail())
			->setBody(
				$this->template->render(
					'emails/email.html.twig',
					['booking' => $booking]
				),
				'text/html'
			);

		$this->mail->send($message);
	}
}