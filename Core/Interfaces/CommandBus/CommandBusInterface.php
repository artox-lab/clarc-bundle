<?php
/**
 * Command bus interface
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\CommandBus;

interface CommandBusInterface
{
    /**
     * Running command
     *
     * @param object $command Command
     *
     * @return mixed
     */
    public function execute($command);
}