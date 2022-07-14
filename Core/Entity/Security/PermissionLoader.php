<?php
/**
 * Permission loader
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security;

interface PermissionLoader
{
    public function loadByRole(string $roleName): array;
}
