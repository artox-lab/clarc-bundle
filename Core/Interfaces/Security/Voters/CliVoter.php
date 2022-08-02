<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Security\Voters;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CliVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return 'cli' === PHP_SAPI;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        return true;
    }
}
