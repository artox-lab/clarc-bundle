<?php

/**
 * Message bus based on symfony/messenger
 *
 * @author Dmitry Meliukh <d.meliukh@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\MessageBus;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\MessageBus\MessageBusInterface as ArtoxLabMessageBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class MessageBus implements ArtoxLabMessageBusInterface
{

    /**
     * Message bus
     *
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * MessageBus constructor.
     *
     * @param MessageBusInterface $messageBus Message bus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * Publish message to queue messages
     *
     * @param object|Envelope $message Message
     *
     * @return void
     */
    public function publish($message): void
    {
        $this->messageBus->dispatch($message);
    }

}
