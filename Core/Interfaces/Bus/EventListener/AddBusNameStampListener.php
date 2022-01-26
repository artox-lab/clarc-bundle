<?php
/**
 * Add bus name stamp to envelope by transport and bus name map
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Symfony\Component\Messenger\Stamp\BusNameStamp;

class AddBusNameStampListener implements EventSubscriberInterface
{
    private array $mapping;

    /**
     * @param array<string, string> $mapping An array, keyed by "transport name", set to bus name
     */
    public function __construct(array $mapping = [])
    {
        $this->mapping = $mapping;
    }

    public function onMessageReceived(WorkerMessageReceivedEvent $event): void
    {
        if (!isset($this->mapping[$event->getReceiverName()])) {
            return;
        }

        if (null === $event->getEnvelope()->last(BusNameStamp::class)) {
            $event->addStamps(new BusNameStamp($this->mapping[$event->getReceiverName()]));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // must have lower priority than other listeners to set up correct message bus
            WorkerMessageReceivedEvent::class => ['onMessageReceived', -100],
        ];
    }
}
