<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Interfaces;

use DateTimeInterface;

interface SoftDeletableInterface
{
    public function getDeletedAt(): ?DateTimeInterface;

    public function setDeletedAt(?DateTimeInterface $deletedAt = null): void;

    public function isDeleted(): bool;
}
