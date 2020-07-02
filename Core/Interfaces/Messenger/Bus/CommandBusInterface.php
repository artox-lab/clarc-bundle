<?php
/**
 * Command bus interface
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Messenger\Bus;

interface CommandBusInterface
{
    /**
     * @param object $command
     *
     * @return void
     */
    public function execute($command): void;
}
