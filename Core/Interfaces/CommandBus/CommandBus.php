<?php
/**
 * Command bus based on symfony/messenger
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\CommandBus;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Commands\AbstractCommand;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusInterface
{
    use HandleTrait;

    /**
     * CommandBus constructor.
     *
     * @param MessageBusInterface $messageBus Message bus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * Executing command
     *
     * @param AbstractCommand $command Command
     *
     * @return mixed The handler returned value
     */
    public function execute(AbstractCommand $command)
    {
        return $this->handle($command);
    }

}
