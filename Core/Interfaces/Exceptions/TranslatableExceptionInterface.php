<?php
/**
 * Provides interface for exceptions that could be translate
 *
 * @author Ilya Rakavets <i.rakovets@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Exceptions;

interface TranslatableExceptionInterface
{

    /**
     * Get an array of parameters that will replace placeholders in the message
     *
     * @return array<string, string>
     */
    public function getParameters(): array;

}
