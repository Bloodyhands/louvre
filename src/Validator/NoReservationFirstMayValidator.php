<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoReservationFirstMayValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{
		if ($value->format('m/d') == 05/01) {
			$this->context->buildViolation($constraint->message)
				->addViolation();
		}
	}
}