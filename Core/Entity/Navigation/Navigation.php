<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Navigation;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Navigation
{
    private string $name;

    private bool $isShowOrphanedRoot = true;

    /**
     * @var Collection<NavigationItem>
     */
    private Collection $items;

    public function __construct(string $name)
    {
        $this->name  = $name;
        $this->items = new ArrayCollection();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function items(): Collection
    {
        return $this->items;
    }

    public function addItem(NavigationItem $item): void
    {
        $this->items->add($item);
    }

    public function removeItem(NavigationItem $item): void
    {
        $this->items->removeElement($item);
    }

    public function isShowOrphanedRoot(): bool
    {
        return $this->isShowOrphanedRoot;
    }

    public function changeShowOrphanedRoot(bool $show): void
    {
        $this->isShowOrphanedRoot = $show;
    }
}
