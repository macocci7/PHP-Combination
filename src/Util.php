<?php

namespace Macocci7\PhpCombination;

class Util
{
    /**
     * returns system bit
     * @param
     * @return  int
     */
    public static function systemBit()
    {
        // PHP_INT_MAX:
        // - 32bit-system: 4 (bytes)
        // - 64bit-system: 8 (bytes)
        return PHP_INT_MAX * 8;
    }
}
