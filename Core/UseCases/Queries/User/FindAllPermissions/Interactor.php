<?php
/**
 * Find all current user permissions
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Queries\User\FindAllPermissions;

use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security\PermissionStorage;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands\AbstractInteractor;

class Interactor extends AbstractInteractor
{
    private PermissionStorage $permissionStorage;

    public function __construct(PermissionStorage $permissionStorage)
    {
        $this->permissionStorage = $permissionStorage;
    }

    public function __invoke(Command $command): array
    {
        return $this->permissionStorage->getPermissions();
    }
}
