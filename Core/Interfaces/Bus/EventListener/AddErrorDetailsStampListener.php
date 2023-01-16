<?php

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Stamp\ErrorDetailsStamp;

/**
 * Replace original \Symfony\Component\Messenger\EventListener\AddErrorDetailsStampListener
 * @see https://github.com/symfony/symfony/issues/45944
 */
class AddErrorDetailsStampListener implements EventSubscriberInterface
{
    public function onMessageFailed(WorkerMessageFailedEvent $event): void
    {
        $throwable = $event->getThrowable();

        if ($throwable instanceof HandlerFailedException) {
            $throwable = $throwable->getPrevious();
        }

        if ($throwable === null) {
            return;
        }

        $stamp = new ErrorDetailsStamp($throwable::class, $throwable->getCode(), $throwable->getMessage());

        $previousStamp = $event->getEnvelope()->last(ErrorDetailsStamp::class);

        // Do not append duplicate information
        if ($previousStamp === null || ! $previousStamp->equals($stamp)) {
            $event->addStamps($stamp);
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
