<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NoReservationTuesday
 * @package App\Validator
 *
 * @Annotation
 */
class NoReservationTuesday extends Constraint
{
	public $message = "Impossible de réserver le mardi";
}
