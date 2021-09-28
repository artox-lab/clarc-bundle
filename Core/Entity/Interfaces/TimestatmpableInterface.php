<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Interfaces;

use DateTimeInterface;

interface TimestatmpableInterface
{
    public function getCreatedAt(): DateTimeInterface;

    public function getUpdatedAt(): DateTimeInterface;

    public function setUpdatedAt(DateTimeInterface $updatedAt): void;
}
