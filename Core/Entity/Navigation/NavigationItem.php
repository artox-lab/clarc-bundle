<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class NavigationItem
{
    private string $title;

    private ?string $link = null;

    private ?string $icon = null;

    private Collection $permissions;

    /**
     * @var Collection<NavigationItem>
     */
    private Collection $children;

    public function __construct(string $title)
    {
        $this->title       = $title;
        $this->children    = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    public function title(): string
    {
        return $this->title;
    }

    public function icon(): ?string
    {
        return $this->icon;
    }

    public function changeIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function link(): ?string
    {
        return $this->link;
    }

    public function changeLink(?string $link): void
    {
        $this->link = $link;
    }

    public function permissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(string $permission): void
    {
        $this->permissions->add($permission);
    }

    public function removePermission(string $permission): void
    {
        $this->permissions->removeElement($permission);
    }

    public function clearPermissions(): void
    {
        $this->permissions->clear();
    }

    /**
     * @return Collection<NavigationItem>
     */
    public function children(): Collection
    {
        return $this->children;
    }

    public function addChild(NavigationItem $navigation): void
    {
        $this->children->add($navigation);
    }

    public function removeChild(NavigationItem $navigation): void
    {
        $this->children->removeElement($navigation);
    }
}
