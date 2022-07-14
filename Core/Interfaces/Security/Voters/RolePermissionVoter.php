<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Security\Voters;

use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security\PermissionStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RolePermissionVoter extends Voter
{
    private PermissionStorage $permissionStorage;

    public function __construct(PermissionStorage $permissionStorage)
    {
        $this->permissionStorage = $permissionStorage;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        return in_array($attribute, $this->permissionStorage->getPermissions(), true);
    }
}
