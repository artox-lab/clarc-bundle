<?php
/**
 * Event bus
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Messenger\Bus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class EventBus implements EventBusInterface
{
    /**
     * Event bus
     *
     * @var MessageBusInterface
     */
    private $eventBus;

    /**
     * EventBus constructor.
     *
     * @param MessageBusInterface $eventBus Event bus
     */
    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @param object|Envelope $event
     *
     * @return mixed|\Symfony\Component\Messenger\Envelope
     */
    public function dispatch($event)
    {
        return $this->eventBus->dispatch($event);
    }
}
