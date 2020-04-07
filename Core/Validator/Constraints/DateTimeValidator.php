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

        \DateTime::createFromFormat($constraint->format, $value->format($constraint->format));

        $errors = \DateTime::getLastErrors();

        if (0 < $errors['error_count']) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(DateTime::INVALID_FORMAT_ERROR)
                ->addViolation();

            return;
        }

        foreach ($errors['warnings'] as $warning) {
            if ('The parsed date was invalid' === $warning) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(DateTime::INVALID_DATE_ERROR)
                    ->addViolation();
            } else if ('The parsed time was invalid' === $warning) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(DateTime::INVALID_TIME_ERROR)
                    ->addViolation();
            } else {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(DateTime::INVALID_FORMAT_ERROR)
                    ->addViolation();
            }
        }
    }

}
