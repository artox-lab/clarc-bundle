<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Traits;

use DateTimeInterface;

trait SoftDeletableTrait
{
    protected ?DateTimeInterface $deletedAt = null;

    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeInterface $deletedAt = null): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }
}
