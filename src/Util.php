<?php

namespace Macocci7\PhpCombination;

/**
 * class for utility
 * @author  macocci7 <macocci7@yahoo.co.jp>
 * @license MIT
 */
class Util
{
    /**
     * returns system bit
     */
    public static function systemBit(): int|float
    {
        // PHP_INT_MAX:
        // - 32bit-system: 4 (bytes)
        // - 64bit-system: 8 (bytes)
        return PHP_INT_MAX * 8;
    }

    /**
     * validates the array
     * @param   array<int, int|float|string>  $array
     * @thrown  \Exception
     */
    public static function validateArray(array $array): bool
    {
        if (empty($array)) {
            throw new \Exception("Empty array set.");
        }
        foreach ($array as $i => $v) {
            if (!is_int($i)) {
                throw new \Exception("Array keys must be integer.");
            }
            if (!is_int($v) && !is_float($v) && !is_string($v)) {
                throw new \Exception("Array elements must be int, float or strings.");
            }
        }
        return true;
    }

    /**
     * validates the arrays
     * @param   mixed[]     $arrays
     * @thrown  \Exception
     */
    public static function validateArrays(array $arrays): bool
    {
        // check if empty
        if (empty($arrays)) {
            throw new \Exception("Empty array set.");
        }
        // check types
        $counts = [];
        foreach ($arrays as $index => $array) {
            if (!is_array($array)) {
                $message = sprintf("index[%d]: Array expected.", $index);
                throw new \Exception($message);
            }
            $counts[] = count($array);
        }
        // check number of combination patterns
        $patterns = 1;
        foreach ($counts as $count) {
            $patterns *= $count;
        }
        if (is_float($patterns)) {  // @phpstan-ignore-line conditionalType.alwaysFalse
            $message = $patterns . " patterns found (over limit).";
            throw new \Exception($message);
        }
        return true;
    }
}
