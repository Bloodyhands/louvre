<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoReservationFirstNovemberValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{
		if ($value->format('m/d') == 11/01) {
			$this->context->buildViolation($constraint->message)
				->addViolation();
		}
	}
}