<?php

/**
 * Event bus based on symfony/messenger
 *
 * @author Dmitry Meliukh <d.meliukh@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\EventBus;

use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus\DomainEventBusInterface;
use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus\DomainEventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EventBus implements DomainEventBusInterface
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
     * Dispatch domain event
     *
     * @param DomainEventInterface $event Event
     *
     * @return void
     */
    public function dispatch(DomainEventInterface $event): void
    {
        $this->eventBus->dispatch($event);
    }

}
