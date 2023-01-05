<?php

/**
 * Command bus interface
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\CommandBus;

interface CommandBusInterface
{

    /**
     * Executing command
     *
     * @param object $command Command
     *
     * @return mixed The handler returned value
     */
    public function execute(object $command);

}
