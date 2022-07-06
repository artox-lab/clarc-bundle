<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security;

interface AuthorizationChecker
{
    /**
     * Checks if the attribute is granted against the current authentication token and optionally supplied subject.
     *
     * @param mixed $attribute A single attribute to vote on (can be of any type)
     *
     */
    public function isGranted(mixed $attribute, mixed $subject = null): bool;
}
