<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoReservationSundayValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{
		if ($value->format('w') == 0) {
			$this->context->buildViolation($constraint->message)
				->addViolation();
		}
	}
}