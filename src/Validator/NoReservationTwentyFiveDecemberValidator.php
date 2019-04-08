<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoReservationTwentyFiveDecemberValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{
		if ($value->format('m/d') == 12/25) {
			$this->context->buildViolation($constraint->message)
				->addViolation();
		}
	}
}