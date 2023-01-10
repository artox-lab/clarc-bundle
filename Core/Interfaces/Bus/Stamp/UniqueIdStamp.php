<?php

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\Stamp;

use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

class UniqueIdStamp implements StampInterface
{
    private UuidInterface|string $uniqueId;

    public function __construct()
    {
        $this->uniqueId = $this->generateUniqueId();
    }

    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    private function generateUniqueId(): UuidInterface|string
    {
        if (interface_exists(UuidInterface::class)) {
            return (new UuidFactory())->uuid4();
        }

        return uniqid();
    }
}
