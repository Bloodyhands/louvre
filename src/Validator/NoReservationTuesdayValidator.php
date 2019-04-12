<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoReservationTuesdayValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{
		if ($value->format('w') == 2) {
			$this->context->buildViolation($constraint->message)
				->addViolation();
		}
	}
}