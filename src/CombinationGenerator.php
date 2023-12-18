<?php

namespace Macocci7\PhpCombination;

use Macocci7\PhpCombination\Util;

class CombinationGenerator
{
    /**
     * returns all combinations
     * @param   array   $items
     * @return  \Generator
     */
    public function all(array $items)
    {
        $count = count($items);
        if (0 === $count) {
            throw new \Exception("Empty array set.");
        }
        if ($count >= Util::systemBit() - 1) {
            throw new \Exception("Too many elements.");
        }
        $numberOfAllPatterns = 2 ** $count;
        $format = '%0' . $count . 'b';
        $combinations = [];
        for ($i = $numberOfAllPatterns - 1; $i > 0; $i--) {
            $combination = [];
            foreach (str_split(sprintf($format, $i)) as $index => $bit) {
                if ((bool) $bit) {
                    $combination[] = $items[$index];
                }
            }
            yield $combination;
        }
    }

    /**
     * returns all pairs
     * @param   array   $items
     * @return  \Generator
     */
    public function pairs(array $items)
    {
        if (count($items) < 2) {
            throw new \Exception("Too few elements.");
        }
        $pairs = [];
        $lastIndex = count($items) - 1;
        for ($x = 0; $x < $lastIndex; $x++) {
            for ($y = $x + 1; $y <= $lastIndex; $y++) {
                yield [$items[$x], $items[$y]];
            }
        }
    }

    /**
     * returns all combinations of $n elements
     * @param   array   $items
     * @param   int     $n
     * @return  \Generator
     */
    public function ofN(array $items, int $n)
    {
        /**
         * ex) $items = [1,2,3,4], $n = 3
         * ==> [1,2,3], [1,2,4], [1,3,4], [2,3,4]
         */
        if ($n < 1 || count($items) < $n) {
            throw new \Exception("Invalid number specified.");
        }
        $r = [];
        foreach ($this->all($items) as $c) {
            if (count($c) === $n) {
                yield $c;
            }
        }
    }

    /**
     * returns all combinations of $a to $b elements
     * @param   array   $items
     * @param   int     $a
     * @param   int     $b
     * @return  \Generator
     */
    public function ofA2B(array $items, int $a, int $b)
    {
        if ($a < 1 || $b < 1) {
            throw new \Exception("Invalid number specified.");
        }
        if ($a >= $b) {
            throw new \Exception("A must be less than B.");
        }
        $count = count($items);
        if ($b > $count) {
            throw new \Exception("B exceeds the number of elements.");
        }
        $combinations = [];
        foreach ($this->all($items) as $c) {
            $count = count($c);
            if ($a <= $count && $count <= $b) {
                yield $c;
            }
        }
    }
}
