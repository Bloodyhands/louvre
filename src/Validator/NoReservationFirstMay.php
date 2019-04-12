<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NoReservationFirstMay
 * @package App\Validator
 *
 * @Annotation
 */
class NoReservationFirstMay extends Constraint
{
	public $message = "Impossible de réserver le 1er mai";
}