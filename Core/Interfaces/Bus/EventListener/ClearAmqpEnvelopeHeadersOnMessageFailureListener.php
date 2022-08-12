<?php
/**
 * To prevent resending failed message amqp headers from previous amqp envelope,
 * when the sender of the message is not the current application, clear new amqp envelope headers
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\EventListener;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\Stamp\ConfirmedBySelfOriginStamp;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;

class ClearAmqpEnvelopeHeadersOnMessageFailureListener implements EventSubscriberInterface
{
    public function onMessageFailed(WorkerMessageFailedEvent $event): void
    {
        $envelope = $event->getEnvelope();

        if (null !== $envelope->last(ConfirmedBySelfOriginStamp::class)) {
            $event->addStamps(
                AmqpStamp::createWithAttributes(['headers' => []], $envelope->last(AmqpStamp::class))
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // must have higher priority than SendFailedMessageForRetryListener
            WorkerMessageFailedEvent::class => ['onMessageFailed', 200],
        ];
    }
}
