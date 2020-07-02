<?php
/**
 * Event bus interface
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus;

interface EventBus
{
    /**
     * @param object $event
     *
     * @return mixed
     */
    public function dispatch($event);
}
