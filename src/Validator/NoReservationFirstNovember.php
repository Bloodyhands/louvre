<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class NoReservationFirstNovember
 * @package App\Validator
 *
 * @Annotation
 */
class NoReservationFirstNovember extends Constraint
{
	public $message = "Impossible de réserver le 1er novembre";
}