<?php
/**
 * Config permission loader
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Security;

use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security\PermissionLoader;

class ConfigPermissionLoader implements PermissionLoader
{
    /**
     * @var \string[][]
     */
    private array $config;

    /**
     * @param array<string, array<string>> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array|string[]
     */
    public function loadByRole(string $roleName): array
    {
        return $this->config[$roleName] ?? [];
    }
}
