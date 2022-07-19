<?php
/**
 * Add AMQP routing key middleware
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\Middleware;

use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AddAmqpRoutingKeyMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null === $envelope->last(AmqpStamp::class)) {
            $envelope = $envelope->with(new AmqpStamp($this->getRoutingKey($envelope)));
        }

        return $stack->next()->handle($envelope, $stack);
    }

    /**
     * Convert message class name to string in snake_case separated by dots
     *
     * @param Envelope $envelope
     *
     * @return string
     */
    private function getRoutingKey(Envelope $envelope): string
    {
        return str_replace('\\', '.', get_class($envelope->getMessage()));
    }
}
