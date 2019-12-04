<?php
/**
 * Command bus interface
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\CommandBus;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands\AbstractCommand;

interface CommandBusInterface
{

    /**
     * Executing command
     *
     * @param AbstractCommand $command Command
     *
     * @return mixed The handler returned value
     */
    public function execute(AbstractCommand $command);

}
