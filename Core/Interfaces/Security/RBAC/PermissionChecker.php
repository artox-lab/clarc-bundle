<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Security\RBAC;

class PermissionChecker
{
    /**
     * @var array|Role[]
     */
    private array $roles = [];

    /**
     * @param array<string, array<string>> $rolesPermissions
     */
    public function __construct(array $rolesPermissions)
    {
        foreach ($rolesPermissions as $roleName => $permissions) {
            $this->roles[$roleName] = new Role($roleName, $permissions);
        }
    }

    public function getRole(string $name): ?Role
    {
        return $this->roles[$name] ?? null;
    }

    public function hasRolePermission(string $roleName, string $permission): bool
    {
        $role = $this->getRole($roleName);

        if (null === $role) {
            return false;
        }

        return $role->hasPermission($permission);
    }

    public function hasAnyRolePermission(string $permission): bool
    {
        return in_array($permission, $this->getAllRolesPermissions(), true);
    }

    /**
     * @return array<string> all roles permissions
     */
    public function getAllRolesPermissions(): array
    {
        $permissions = [];

        foreach ($this->roles as $role) {
            $permissions = array_merge($permissions, $role->permissions());
        }

        return array_unique($permissions);
    }
}
