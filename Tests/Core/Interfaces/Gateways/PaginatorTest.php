<?php

declare(strict_types=1);

namespace Core\Interfaces\Gateways;

use ArtoxLab\Bundle\ClarcBundle\Core\Interfaces\Gateways\Paginator;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    /**
     * @test
     */
    public function paginator_iterable(): void
    {
        $data  = ['hello', 'world', 'foo', 'bur'];
        $total = count($data);
        $pager = new Paginator(1, 4, $data, $total);

        $result = [];
        foreach ($pager as $item) {
            $result[] = $item;
        }

        self::assertEquals($data, $result);
    }

    /**
     * @test
     */
    public function paginator_countable(): void
    {
        $data  = ['foo', 'bar', 'baz'];
        $pager = new Paginator(1, 3, $data, 15);

        $count = count($pager);

        self::assertEquals(3, $count);
    }
}
