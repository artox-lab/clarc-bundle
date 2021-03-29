<?php
/**
 * Implementation of Paginator
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Gateways;
use ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Interfaces\PaginatorInterface;

class Paginator implements PaginatorInterface
{
    /**
     * Number of page
     *
     * @var integer
     */
    protected $page;

    /**
     * Number of results per page
     *
     * @var integer
     */
    protected $limit;

    /**
     * Results
     *
     * @var array<mixed>
     */
    protected $results;

    /**
     * The total number of results
     *
     * @var integer
     */
    protected $total;

    /**
     * Paginator constructor.
     *
     * @param int          $page    Number of page
     * @param int          $limit   Number of results per page
     * @param array<mixed> $results Results
     * @param int          $total   The total number of results
     */
    public function __construct(int $page, int $limit, array $results, int $total)
    {
        $this->page    = $page;
        $this->limit   = $limit;
        $this->results = $results;
        $this->total   = $total;
    }

    /**
     * Results
     *
     * @return array<mixed>
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * Number of page
     *
     * @return int
     */
    public function getCurrentPage() : int
    {
        return $this->page;
    }

    /**
     * Number of results per page
     *
     * @return int
     */
    public function getLimit() : int
    {
        return $this->limit;
    }

    /**
     * The total number of results
     *
     * @return int
     */
    public function getTotal() : int
    {
        return $this->total;
    }

    /**
     * Map results with callback
     *
     * @param callable $callback Callback
     *
     * @return void
     */
    public function map(callable $callback) : void
    {
        $this->results = array_map($callback, $this->results);
    }

}
