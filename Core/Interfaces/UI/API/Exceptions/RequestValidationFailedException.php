<?php
/**
 * Request validation failed exception
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\UI\API\Exceptions;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestValidationFailedException extends InvalidArgumentException
{
    /**
     * Validation errors
     *
     * @var array
     */
    private $validationErrors = [];

    /**
     * RequestValidationFailedException constructor.
     *
     * @param ConstraintViolationListInterface $violations Validation result
     */
    public function __construct(ConstraintViolationListInterface $violations)
    {
        parent::__construct('Validation error', Response::HTTP_UNPROCESSABLE_ENTITY);

        if (count($violations) < 1) {
            return;
        }

        foreach ($violations as $violation) {
            $this->validationErrors[$violation->getPropertyPath()][] = $violation->getMessage();
        }
    }

    /**
     * Returns validation errors
     *
     * @return array
     */
    public function getValidationErrors() : array
    {
        return $this->validationErrors;
    }

}
