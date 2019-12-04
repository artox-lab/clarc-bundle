<?php
/**
 * Request validation failed exception
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Exceptions;

class RequestValidationFailedException extends ValidationFailedException
{
    /**
     * Request validation failed message
     *
     * @var string
     */
    protected $basicMessage = 'Request validation failed';
}
