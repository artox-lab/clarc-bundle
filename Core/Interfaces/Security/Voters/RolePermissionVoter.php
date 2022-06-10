<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Security\Voters;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Security\RBAC\PermissionChecker;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RolePermissionVoter extends Voter
{
    private PermissionChecker $permissionChecker;

    public function __construct(PermissionChecker $permissionChecker)
    {
        $this->permissionChecker = $permissionChecker;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return $this->permissionChecker->hasAnyRolePermission($attribute);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        $allow = false;

        foreach ($user->getRoles() as $role) {
            if ($this->permissionChecker->hasRolePermission($role, $attribute)) {
                $allow = true;
                break;
            }
        }

        return $allow;
    }
}
