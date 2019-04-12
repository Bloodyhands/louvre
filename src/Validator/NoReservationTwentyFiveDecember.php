<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NoReservationTwentyFiveDecember
 * @package App\Validator
 *
 * @Annotation
 */
class NoReservationTwentyFiveDecember extends Constraint
{
	public $message = "Impossible de réserver le 25 décembre";
}