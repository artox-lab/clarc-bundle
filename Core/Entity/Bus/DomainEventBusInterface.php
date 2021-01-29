<?php

/**
 * Event bus interface
 *
 * @author Dmitry Meliukh <d.meliukh@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus;

interface DomainEventBusInterface
{

    /**
     * Dispatch domain event
     *
     * @param DomainEventInterface $event Event
     *
     * @return void
     */
    public function dispatch(DomainEventInterface $event): void;

}
