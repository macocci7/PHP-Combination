<?php

namespace Macocci7\PhpCombination;

class Combination
{
    /**
     * returns system bit
     * @param
     * @return  int
     */
    public function systemBit()
    {
        // PHP_INT_MAX:
        // - 32bit-system: 4 (bytes)
        // - 64bit-system: 8 (bytes)
        return PHP_INT_MAX * 8;
    }

    /**
     * returns all combinations
     * @param   array   $items
     * @param   bool    $sort = false
     * @return  array
     */
    public function all(array $items, bool $sort = false)
    {
        $count = count($items);
        if (0 === $count) {
            throw new \Exception("Empty array set.");
        }
        if ($count >= $this->systemBit() - 1) {
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
            $combinations[] = $combination;
        }
        if ($sort) {
            $strs = array_map(fn ($c): string => implode(',', $c), $combinations);
            array_multisort($strs, SORT_ASC, SORT_STRING, $combinations);
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
            throw new \Exception("Too few elements.");
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
     * @param   bool    $sort = false
     * @return  array
     */
    public function ofN(array $items, int $n, bool $sort = false)
    {
        /**
         * ex) $items = [1,2,3,4], $n = 3
         * ==> [1,2,3], [1,2,4], [1,3,4], [2,3,4]
         */
        if ($n < 1 || count($items) < $n) {
            throw new \Exception("Invalid number specified.");
        }
        $r = [];
        foreach ($this->all($items, $sort) as $c) {
            if (count($c) === $n) {
                $r[] = $c;
            }
        }
        return $r;
    }

    /**
     * returns all combinations of $a to $b elements
     * @param   array   $items
     * @param   int     $a
     * @param   int     $b
     * @param   bool    $sort = false
     * @return  array
     */
    public function ofA2B(array $items, int $a, int $b, bool $sort = false)
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
        foreach ($this->all($items, $sort) as $c) {
            $count = count($c);
            if ($a <= $count && $count <= $b) {
                $combinations[] = $c;
            }
        }
        return $combinations;
    }
}
