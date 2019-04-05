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

	public function mail(Booking $booking)
	{
		$message = (new \Swift_Message('Hello email'))
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