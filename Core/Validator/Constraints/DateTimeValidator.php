<?php

/**
 * Validator: DateTime
 *
 * @author Dmitry Meliukh <d.meliukh@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\DateTimeValidator as SymfonyDateTimeValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class DateTimeValidator extends SymfonyDateTimeValidator
{

    /**
     * Validate
     *
     * @param mixed      $value      Value
     * @param Constraint $constraint Constraint
     *
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        if (false === $constraint instanceof DateTime) {
            throw new UnexpectedTypeException($constraint, DateTime::class);
        }

        if (null === $value
            || '' === $value
        ) {
            return;
        }

        if (false === $value instanceof \DateTime) {
            throw new UnexpectedValueException($value, 'DateTime');
        }
    }

}
