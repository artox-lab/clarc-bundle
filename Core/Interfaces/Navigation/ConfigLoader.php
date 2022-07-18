<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Navigation;

use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation\Navigation;
use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation\NavigationItem;
use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation\NavigationLoader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ConfigLoader implements NavigationLoader
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function load(): Collection
    {
        $collection = new ArrayCollection();

        foreach ($this->config as $key => $data) {
            $navigation = new Navigation($key);
            $navigation->changeShowOrphanedRoot($data['show_orphaned_root']);

            foreach ($data['items'] as $itemConfig) {
                $navigation->addItem($this->buildItem($itemConfig));
            }

            $collection->add($navigation);
        }

        return $collection;
    }

    private function buildItem(array $config): NavigationItem
    {
        $navigation = new NavigationItem($config['title']);
        $navigation->changeIcon($config['icon']);
        $navigation->changeLink($config['link']);

        foreach ($config['permissions'] as $permission) {
            $navigation->addPermission($permission);
        }

        if (!empty($config['children'])) {
            foreach ($config['children'] as $child) {
                $navigation->addChild($this->buildItem($child));
            }
        }

        return $navigation;
    }
}
