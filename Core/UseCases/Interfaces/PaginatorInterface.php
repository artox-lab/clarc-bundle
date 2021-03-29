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
     * Number of page
     *
     * @return int
     */
    public function getCurrentPage() : int;

    /**
     * Number of results per page
     *
     * @return int
     */
    public function getLimit() : int;

    /**
     * Results
     *
     * @return array<mixed>
     */
    public function getResults() : array;

    /**
     * The total number of results
     *
     * @return int
     */
    public function getTotal() : int;

    /**
     * Map results with callback
     *
     * @param callable $callback Callback
     *
     * @return void
     */
    public function map(callable $callback) : void;

}
