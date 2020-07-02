<?php
/**
 * Command bus interface
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus;

interface CommandBus
{
    /**
     * @param object $command
     *
     * @return void
     */
    public function execute($command): void;
}
