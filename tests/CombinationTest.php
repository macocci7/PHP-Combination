<?php

declare(strict_types=1);

namespace Macocci7\PhpCombination;

require('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use Macocci7\PhpCombination\Combination;

final class CombinationTest extends TestCase
{
    public function test_all_can_return_all_combinations_correctly(): void
    {
        $cases = [
            ['items' => [], 'expect' => null, ],
            ['items' => [1], 'expect' => [[1]], ],
            ['items' => [1, 2, ], 'expect' => [[2], [1], [1, 2, ], ], ],
            ['items' => [1, 2, 3, ], 'expect' => [[3], [2], [2, 3, ], [1], [1, 3, ], [1, 2, ], [1, 2, 3, ], ], ],
        ];
        $c = new Combination();
        foreach ($cases as $case) {
            $this->assertSame($case['expect'], $c->all($case['items']));
        }
    }

    public function test_pairs_can_return_all_pairs_correctly(): void
    {
        $cases = [
            ['items' => [], 'expect' => null, ],
            ['items' => [1], 'expect' => null, ],
            ['items' => [1, 2, ], 'expect' => [[1, 2, ]], ],
            ['items' => [1, 2, 3, ], 'expect' => [[1, 2, ], [1, 3, ], [2, 3, ], ], ],
            ['items' => [1, 2, 3, 4, ], 'expect' => [[1, 2, ], [1, 3, ], [1, 4, ], [2, 3, ], [2, 4, ], [3, 4, ], ], ],
        ];
        $c = new Combination();
        foreach ($cases as $case) {
            $this->assertSame($case['expect'], $c->pairs($case['items']));
        }
    }

    public function test_ofN_can_return_all_combinations_of_n_elements_correctly(): void
    {
        $cases = [
            ['items' => [], 'n' => 1, 'expect' => null, ],
            ['items' => [1], 'n' => -1, 'expect' => null, ],
            ['items' => [1], 'n' => 0, 'expect' => null, ],
            ['items' => [1], 'n' => 1, 'expect' => [[1]], ],
            ['items' => [1], 'n' => 2, 'expect' => null, ],
            ['items' => [1, 2, ], 'n' => 0, 'expect' => null, ],
            ['items' => [1, 2, ], 'n' => 1, 'expect' => [[2], [1], ], ],
            ['items' => [1, 2, ], 'n' => 2, 'expect' => [[1, 2, ]], ],
            ['items' => [1, 2, ], 'n' => 3, 'expect' => null, ],
            ['items' => [1, 2, 3, ], 'n' => 0, 'expect' => null, ],
            ['items' => [1, 2, 3, ], 'n' => 1, 'expect' => [[3], [2], [1], ], ],
            ['items' => [1, 2, 3, ], 'n' => 2, 'expect' => [[2, 3, ], [1, 3, ], [1, 2, ], ], ],
            ['items' => [1, 2, 3, ], 'n' => 3, 'expect' => [[1, 2, 3, ]], ],
            ['items' => [1, 2, 3, ], 'n' => 4, 'expect' => null, ],
        ];
        $c = new Combination();
        foreach ($cases as $case) {
            $this->assertSame($case['expect'], $c->ofN($case['items'], $case['n']));
        }
    }
}
