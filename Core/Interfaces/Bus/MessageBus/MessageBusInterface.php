<?php

/**
 * Message bus interface
 *
 * @author Dmitry Meliukh <d.meliukh@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\MessageBus;

interface MessageBusInterface
{

    /**
     * Publish message to queue messages
     *
     * @param object $message Message
     *
     * @return void
     */
    public function publish($message): void;

}
