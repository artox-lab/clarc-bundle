<?php
/**
 * Event bus interface
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Messenger\Bus;

interface EventBusInterface
{
    /**
     * @param object $event
     *
     * @return mixed
     */
    public function dispatch($event);
}
