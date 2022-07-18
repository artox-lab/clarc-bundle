<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation;

use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Security\PermissionStorage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class NavigationStorage
{
    private PermissionStorage $permissionStorage;

    private NavigationLoader $navigationLoader;

    public function __construct(PermissionStorage $permissionStorage, NavigationLoader $loader)
    {
        $this->permissionStorage = $permissionStorage;
        $this->navigationLoader  = $loader;
    }

    public function all(): Collection
    {
        $collection      = new ArrayCollection();
        $userPermissions = $this->permissionStorage->getPermissions();

        foreach ($this->navigationLoader->load() as $navigation) {
            /** @var Navigation $newNavigation */
            $newNavigation = clone $navigation;

            $this->filterByPermissions($newNavigation->items(), $userPermissions);

            $collection->add($newNavigation);
        }

        return $collection;
    }

    private function filterByPermissions(Collection $items, array $permissions): Collection
    {
        /** @var NavigationItem $item */
        foreach ($items as $item) {
            if (!$item->permissions()->isEmpty() && !array_intersect($item->permissions()->toArray(), $permissions)) {
                $items->removeElement($item);

                continue;
            }

            $this->filterByPermissions($item->children(), $permissions);
        }

        return $items;
    }
}
