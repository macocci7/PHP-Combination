<?php

declare(strict_types=1);

namespace Macocci7\PhpCombination;

require_once('../vendor/autoload.php');
require_once('./UseInPhpUnit.class.php');

use PHPUnit\Framework\TestCase;
use Macocci7\PhpCombination\Examples\UseInPhpUnit;
use Macocci7\PhpCombination\Combination;

final class UseInPhpUnitTest extends TestCase
{
    public static function provide_order_can_order_correctly(): array
    {
        $products = [ 1101, 1102, ];
        $sizes = [ 'S', 'M', 'L', ];
        $colors = [ 'White', 'Black', ];
        $amount = [ 1, 2, ];
        $c = new Combination();
        $data = [];
        foreach (
            $c->fromArrays([$products, $sizes, $colors, $amount]) as $e
        ) {
            $data[implode(', ', $e)] = $e;
        }
        return $data;
    }

    /**
     * @dataProvider provide_order_can_order_correctly
     */
    public function test_order_can_order_correctly(
        int $productId,
        string $size,
        string $color,
        int $amount
    ): void {
        $u = new UseInPhpUnit();
        $this->assertTrue($u->order(
            $productId,
            $size,
            $color,
            $amount
        ));
    }
}
