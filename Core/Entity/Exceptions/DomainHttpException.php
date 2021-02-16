<?php
/**
 * Domain HTTP exception
 *
 * @author Bogdan Fedorenko <b.fedorenko@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class DomainHttpException extends HttpException
{

    /**
     * DomainHttpException constructor.
     *
     * @param string $message
     * @param int    $statusCode
     */
    public function __construct(string $message, int $statusCode)
    {
        parent::__construct($statusCode, $message);
    }

}
