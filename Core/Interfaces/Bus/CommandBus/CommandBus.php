<?php

/**
 * Command bus based on symfony/messenger
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\CommandBus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusInterface
{
    use HandleTrait;

    /**
     * CommandBus constructor.
     *
     * @param MessageBusInterface $commandBus Command bus
     */
    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    /**
     * Executing command
     *
     * @param object $command Command
     *
     * @return mixed The handler returned value
     */
    public function execute(object $command)
    {
        return $this->handle($command);
    }

}
