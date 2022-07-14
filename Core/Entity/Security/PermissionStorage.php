<?php
/**
 * Return current user permission
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security;

interface PermissionStorage
{
    /**
     * Get permissions list
     *
     * @return array<string>
     */
    public function getPermissions(): array;
}
