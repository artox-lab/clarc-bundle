<?php
/**
 * Command bus
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Messenger\Bus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus\CommandBus as CommandBusInterface;

class CommandBus implements CommandBusInterface
{
    /**
     * Command bus
     *
     * @var MessageBusInterface
     */
    private $commandBus;

    /**
     * CommandBus constructor.
     *
     * @param MessageBusInterface $commandBus Command bus
     */
    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param object|Envelope $command
     *
     * @return void
     */
    public function execute($command): void
    {
        $this->commandBus->dispatch($command);
    }
}
