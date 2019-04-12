<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NoReservationSunday
 * @package App\Validator
 *
 * @Annotation
 */
class NoReservationSunday extends Constraint
{
	public $message = "Impossible de réserver le dimanche";
}