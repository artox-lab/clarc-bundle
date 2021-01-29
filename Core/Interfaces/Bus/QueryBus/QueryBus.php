<?php

/**
 * Query bus based on symfony/messenger
 *
 * @author Dmitry Meliukh <d.meliukh@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\QueryBus;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Queries\AbstractQuery;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus implements QueryBusInterface
{
    use HandleTrait;

    /**
     * QueryBus constructor.
     *
     * @param MessageBusInterface $queryBus Query bus
     */
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * Executing query command
     *
     * @param AbstractQuery $query Query
     *
     * @return mixed The handler returned value
     */
    public function query(AbstractQuery $query)
    {
        return $this->handle($query);
    }

}
