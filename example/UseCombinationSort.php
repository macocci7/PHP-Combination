<?php

require_once('../vendor/autoload.php');

use Macocci7\PhpCombination\Combination;

// Create an Instance
$c = new Combination();

// All Items
$items = ['A', 'B', 'C', 'D', 'E', ];
echo sprintf("All Items:\n\t(%s)\n\n", implode(", ", $items));

// Set a flag to sort
$sort = true;

// Call back
$f = function (array $array): string {
    return sprintf("(%s)", implode(', ', $array));
};

// All Combinations
echo sprintf(
    "All Combinations:\n\t%s\n\n",
    implode("\n\t", array_map($f, $c->all($items, $sort)))
);

// All Pairs: does not support sorting
echo sprintf(
    "All Pairs:\n\t%s\n\n",
    implode("\n\t", array_map($f, $c->pairs($items)))
);

// All Combinations of $n elements
$n = 3;
echo sprintf(
    "All Combinations of %d elements:\n\t%s\n\n",
    $n,
    implode("\n\t", array_map($f, $c->ofN($items, $n, $sort)))
);

// All Combinations of $a to $b elements
$a = 3;
$b = 4;
echo sprintf(
    "All Combinations of %d to %d elements:\n\t%s\n\n",
    $a,
    $b,
    implode("\n\t", array_map($f, $c->ofA2B($items, $a, $b, $sort)))
);
