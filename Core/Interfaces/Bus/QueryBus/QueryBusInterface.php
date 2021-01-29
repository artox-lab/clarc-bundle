<?php

/**
 * Query bus interface
 *
 * @author Dmitry Meliukh <d.meliukh@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Bus\QueryBus;

use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Queries\AbstractQuery;

interface QueryBusInterface
{

    /**
     * Executing query command
     *
     * @param AbstractQuery $query Query
     *
     * @return mixed The handler returned value
     */
    public function query(AbstractQuery $query);

}
