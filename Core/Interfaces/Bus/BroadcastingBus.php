<?php
/**
 * Broadcast the message to an external bus
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class BroadcastingBus implements MessageBusInterface
{
    private MessageBusInterface $broadcastingBus;

    public function __construct(MessageBusInterface $broadcastingBus)
    {
        $this->broadcastingBus = $broadcastingBus;
    }

    public function dispatch(object $message, array $stamps = []): Envelope
    {
        return $this->broadcastingBus->dispatch($message, $stamps);
    }
}
