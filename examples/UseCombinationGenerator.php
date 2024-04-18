<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpCombination\CombinationGenerator;

// Create an Instance
$c = new CombinationGenerator();

// All Items
$items = [ 'A', 'B', 'C', 'D', 'E', ];
echo sprintf("All Items:\n\t(%s)\n\n", implode(", ", $items));

// Common Format
$fmt = "\t(%s)\n";

// All Combinations
echo "All Combinations:\n";
foreach ($c->all($items) as $e) {
    echo sprintf($fmt, implode(', ', $e));
}
echo "\n";

// All Pairs
echo "All Pairs:\n";
foreach ($c->pairs($items) as $e) {
    echo sprintf($fmt, implode(', ', $e));
}
echo "\n";

// All Combinations of $n elements
$n = 3;
echo sprintf("All Combinations of %d elements:\n", $n);
foreach ($c->ofN($items, $n) as $e) {
    echo sprintf($fmt, implode(', ', $e));
}
echo "\n";

// All Combinations of $a to $b elements
$a = 3;
$b = 4;
echo sprintf(
    "All Combinations of %d to %d elements:\n",
    $a,
    $b,
);
foreach ($c->ofA2B($items, $a, $b) as $e) {
    echo sprintf($fmt, implode(', ', $e));
}
echo "\n";
