<?php
/**
 * Query bus interface
 *
 * @author Maxim Petrovich <m.petrovich@artox.com>
 */

namespace ArtoxLab\Bundle\ClarcBundle\Core\Entity\Bus;

interface QueryBus
{

    /**
     * @param object $query
     *
     * @return mixed The handler returned value
     */
    public function query($query);

}
