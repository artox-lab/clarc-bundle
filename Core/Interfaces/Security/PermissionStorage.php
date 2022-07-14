<?php

/**
 * Permission storage for current user
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Security;

use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security\PermissionLoader;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PermissionStorage implements \ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security\PermissionStorage
{
    private TokenStorageInterface $tokenStorage;

    private PermissionLoader $permissionLoader;

    public function __construct(TokenStorageInterface $tokenStorage, PermissionLoader $permissionLoader)
    {
        $this->tokenStorage     = $tokenStorage;
        $this->permissionLoader = $permissionLoader;
    }

    public function getPermissions(): array
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return [];
        }

        $permissions = array_map(function (string $roleName) {
            return $this->permissionLoader->loadByRole($roleName);
        }, $token->getRoleNames());

        return array_unique(array_merge(...$permissions));
    }
}
