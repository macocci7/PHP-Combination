<?php

namespace Macocci7\PhpCombination;

class Combination
{
    /**
     * constructor
     */
    public function __construct()
    {
    }

    /**
     * returns all combinations
     * @param   array   $items
     * @return  array
     */
    public function all(array $items)
    {
        if (empty($items)) {
            return;
        }
        $count = count($items);
        $numberOfAllPatterns = 2 ** $count;
        $bitPatterns = [];
        $format = '%0' . $count . 'b';
        for ($i = 1; $i < $numberOfAllPatterns; $i++) {
            $bitPatterns[] = sprintf($format, $i);
        }
        $combinations = [];
        foreach ($bitPatterns as $bits) {
            $combination = [];
            foreach (str_split($bits) as $index => $bit) {
                if ((bool) $bit) {
                    $combination[] = $items[$index];
                }
            }
            $combinations[] = $combination;
        }
        return $combinations;
    }

    /**
     * returns all pairs
     * @param   array   $items
     * @return  array
     */
    public function pairs(array $items)
    {
        if (count($items) < 2) {
            return;
        }
        $pairs = [];
        $lastIndex = count($items) - 1;
        for ($x = 0; $x < $lastIndex; $x++) {
            for ($y = $x + 1; $y <= $lastIndex; $y++) {
                $pairs[] = [$items[$x], $items[$y]];
            }
        }
        return $pairs;
    }

    /**
     * returns all combinations of $n elements
     * @param   array   $items
     * @param   int     $n
     * @return  array
     */
    public function ofN(array $items, int $n)
    {
        /**
         * ex) $items = [1,2,3,4], $n = 3
         * ==> [1,2,3], [1,2,4], [1,3,4], [2,3,4]
         */
        if ($n < 1) {
            return;
        }
        if (count($items) < $n) {
            return;
        }
        $r = [];
        foreach ($this->all($items) as $c) {
            if (count($c) === $n) {
                $r[] = $c;
            }
        }
        return $r;
    }
}
