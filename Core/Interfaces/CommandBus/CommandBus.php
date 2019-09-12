<?php
/**
 * Command bus based on symfony/messenger
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\CommandBus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\StampInterface;

class CommandBus implements CommandBusInterface
{
    /**
     * Message bus
     *
     * @var MessageBusInterface
     */
    protected $messageBus;

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
     * Running command
     *
     * @param object $command Command
     *
     * @return mixed
     */
    public function execute($command)
    {
        $envelope = $this->messageBus->dispatch($command);

        $last = $envelope->last(HandledStamp::class);

        return $last->getResult();
    }
}