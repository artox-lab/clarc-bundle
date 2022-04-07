<?php
/**
 * Paginator interface
 *
 * @author Artur Turchin <a.turchin@artox.com>
 */

declare(strict_types=1);

namespace ArtoxLab\Bundle\ClarcBundle\Core\UseCases\Interfaces;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @template T
 *
 * @extends IteratorAggregate<T>
 */
interface PaginatorInterface extends Countable, IteratorAggregate
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
     * @return array<T>
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
     * @param callable(T): mixed $callback Callback
     *
     * @return void
     */
    public function map(callable $callback) : void;

    /**
     * @return Traversable<T>
     */
    public function getIterator(): Traversable;
}
