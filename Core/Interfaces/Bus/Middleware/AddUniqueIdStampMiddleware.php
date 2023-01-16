<?php

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\Middleware;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\Stamp\UniqueIdStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AddUniqueIdStampMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null === $envelope->last(UniqueIdStamp::class)) {
            $envelope = $envelope->with(new UniqueIdStamp());
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
