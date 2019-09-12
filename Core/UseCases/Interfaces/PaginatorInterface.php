<?php
/**
 * Paginator interface
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Interfaces;

interface PaginatorInterface
{
    /**
     * Results
     *
     * @return array
     */
    public function items() : array;

    /**
     * Number of page
     *
     * @return int
     */
    public function currentPage() : int;

    /**
     * Number of results per page
     *
     * @return int
     */
    public function limit() : int;

    /**
     * The total number of items
     *
     * @return int
     */
    public function total() : int;
}