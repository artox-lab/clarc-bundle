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
     * @param object $event Event
     *
     * @return void
     */
    public function dispatch($event): void;

}
