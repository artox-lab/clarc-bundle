<?php
/**
 * Some validation failed exception
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Exceptions;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationFailedException extends InvalidArgumentException
{
    /**
     * Basic message
     *
     * @var string
     */
    protected $basicMessage = 'Validation error';

    /**
     * Validation errors
     *
     * @var array<string, array<string>>
     */
    private $validationErrors = [];

    /**
     * RequestValidationFailedException constructor.
     *
     * @param ConstraintViolationListInterface<ConstraintViolationInterface> $violations Validation result
     */
    public function __construct(ConstraintViolationListInterface $violations)
    {
        parent::__construct($this->basicMessage, Response::HTTP_UNPROCESSABLE_ENTITY);

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
     * @return array<string, array<string>>
     */
    public function getValidationErrors() : array
    {
        return $this->validationErrors;
    }

}
