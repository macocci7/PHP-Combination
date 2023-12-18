# PHP-Combination

A simple PHP library to make combinations from array elements.

## Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Classes](#classes)
  - [Combination](#combination)
  - [CombinationGenerator](#combinationgenerator)
  - [How to choose the class to use](#how-to-choose-the-class-to-use)
- [Methods](#methods)
- [Limit on the Number of Array Elements](#limit-on-the-number-of-array-elements)
- [Usage](#usage)
  - [Using Combination](#using-combination)
  - [Using Combination with Sorting](#using-combination-with-sorting)
  - [Using CombinationGenerator](#using-combinationgenerator)
- [Example](#example)
- [LICENSE](#license)

## Requirements

- PHP 8.0.0 (CLI) or later
- Composer

## Installation

```bash
composer require macocci7/php-combination
```

## Classes

There're 2 types of classes for the same methods.

### Combination

```php
Macocci7\PhpCombination\Combination
```

This class returns the result as type of array.

### CombinationGenerator

```php
Macocci7\PhpCombination\CombinationGenerator
```

This class returns the result as type of Generator object.

### How to choose the class to use

There might be 3 factors.

1. **The number of elements of the param and result of all()**

    If the array of the param has $n elements,
    
    the number of array elements of returned array will be:
    
    ```php
    2 ** $n - 1
    ```
    |$n|formula|elements|
    |---:|:---|---:|
    |1|2 ** 1 - 1|1|
    |5|2 ** 5 - 1|31|
    |10|2 ** 10 - 1|1,023|
    |20|2 ** 20 - 1|1,048,575|
    |30|2 ** 30 - 1|1,073,741,823|
    |40|2 ** 40 - 1|1,099,511,627,775|
    |50|2 ** 50 - 1|1,125,899,906,842,623|
    |60|2 ** 60 - 1|1,152,921,504,606,846,975|
    |62|2 ** 62 - 1|4,611,686,018,427,387,903|

2. **Memory limit on your environment**

    Memory usage depends on:
    - the number of array elements to return
    - the type of data

    `Combination` uses much more memory than `CombinationGenerator`.

3. **execution time**

    Looping Generator takes much longer time than looping array.

In some cases, `CombinationGenerator` takes several times longer than `Combination`.

But, `Combination` mostly might exceed memory limit when using param array with more than 22 elements.

Use `CombinationGenerator` then.

It will never exceeds the memory limit, and certanily complete the task.

## Methods

- `all()`: returns all combinations of the param
- `pairs()`: returns all pairs of the param
- `ofN()`: returns all combinations of N elements of the param
- `ofA2B()`: returns all combinations of A to B elements of the param
- `fromArrays()`: returns all combinations of multiple arrays

  `fromArrays()` is only implemented in `Combination` class.

## Limit on the Number of Array Elements

The number of array elements of the param:
- 32bit-system: 30 elements
- 64bit-system: 62 elements

This limit is set to ensure that the number of elements in the returned array does not exceed the PHP upper limit on the index number of array.

The max index number of array in PHP equals to `PHP_INT_MAX`.

`PHP_INT_MAX`:
- 32bit-system: 2147483647 === 2 ** 31 - 1
- 64bit-system: 9223372036854775807 === 2 ** 63 - 1

## Usage

### Using Combination

- PHP:

    ```php
    <?php

    require_once('../vendor/autoload.php');

    use Macocci7\PhpCombination\Combination;

    // Create an Instance
    $c = new Combination();

    // All Items
    $items = ['A', 'B', 'C', 'D', 'E', ];
    echo sprintf("All Items:\n\t(%s)\n\n", implode(", ", $items));

    // Call back
    $f = function (array $array): string {
        return sprintf("(%s)", implode(', ', $array));
    };

    // All Combinations
    echo sprintf(
        "All Combinations:\n\t%s\n\n",
        implode("\n\t", array_map($f, $c->all($items)))
    );

    // All Pairs
    echo sprintf(
        "All Pairs:\n\t%s\n\n",
        implode("\n\t", array_map($f, $c->pairs($items)))
    );

    // All Combinations of $n elements
    $n = 3;
    echo sprintf(
        "All Combinations of %d elements:\n\t%s\n\n",
        $n,
        implode("\n\t", array_map($f, $c->ofN($items, $n)))
    );

    // All Combinations of $a to $b elements
    $a = 3;
    $b = 4;
    echo sprintf(
        "All Combinations of %d to %d elements:\n\t%s\n\n",
        $a,
        $b,
        implode("\n\t", array_map($f, $c->ofA2B($items, $a, $b)))
    );

    // All Combinations of $a1, $a2 and $a3
    $a1 = ['A1', 'A2', ];
    $a2 = ['B1', 'B2', 'B3', ];
    $a3 = ['C1', 'C2', 'C3', 'C4', ];

    echo "All Combinations of multiple arrays:\n";
    echo sprintf("\tArray1: (%s)\n", implode(', ', $a1));
    echo sprintf("\tArray2: (%s)\n", implode(', ', $a2));
    echo sprintf("\tArray3: (%s)\n", implode(', ', $a3));

    $r = $c->fromArrays([$a1, $a2, $a3, ]);
    $n = strlen((string) count($r));
    echo sprintf("\tThere're %d patterns:\n", count($r));
    foreach ($r as $i => $e) {
        echo sprintf("\t%" . $n . "d: (%s)\n", $i + 1, implode(', ', $e));
    }
    ```

- Result:

    ```
    All Items:
        (A, B, C, D, E)

    All Combinations:
        (A, B, C, D, E)
        (A, B, C, D)
        (A, B, C, E)
        (A, B, C)
        (A, B, D, E)
        (A, B, D)
        (A, B, E)
        (A, B)
        (A, C, D, E)
        (A, C, D)
        (A, C, E)
        (A, C)
        (A, D, E)
        (A, D)
        (A, E)
        (A)
        (B, C, D, E)
        (B, C, D)
        (B, C, E)
        (B, C)
        (B, D, E)
        (B, D)
        (B, E)
        (B)
        (C, D, E)
        (C, D)
        (C, E)
        (C)
        (D, E)
        (D)
        (E)

    All Pairs:
        (A, B)
        (A, C)
        (A, D)
        (A, E)
        (B, C)
        (B, D)
        (B, E)
        (C, D)
        (C, E)
        (D, E)

    All Combinations of 3 elements:
        (A, B, C)
        (A, B, D)
        (A, B, E)
        (A, C, D)
        (A, C, E)
        (A, D, E)
        (B, C, D)
        (B, C, E)
        (B, D, E)
        (C, D, E)

    All Combinations of 3 to 4 elements:
        (A, B, C, D)
        (A, B, C, E)
        (A, B, C)
        (A, B, D, E)
        (A, B, D)
        (A, B, E)
        (A, C, D, E)
        (A, C, D)
        (A, C, E)
        (A, D, E)
        (B, C, D, E)
        (B, C, D)
        (B, C, E)
        (B, D, E)
        (C, D, E)

    All Combinations of multiple arrays:
        Array1: (A1, A2)
        Array2: (B1, B2, B3)
        Array3: (C1, C2, C3, C4)
        There're 24 patterns:
        1: (A1, B1, C1)
        2: (A1, B1, C2)
        3: (A1, B1, C3)
        4: (A1, B1, C4)
        5: (A1, B2, C1)
        6: (A1, B2, C2)
        7: (A1, B2, C3)
        8: (A1, B2, C4)
        9: (A1, B3, C1)
        10: (A1, B3, C2)
        11: (A1, B3, C3)
        12: (A1, B3, C4)
        13: (A2, B1, C1)
        14: (A2, B1, C2)
        15: (A2, B1, C3)
        16: (A2, B1, C4)
        17: (A2, B2, C1)
        18: (A2, B2, C2)
        19: (A2, B2, C3)
        20: (A2, B2, C4)
        21: (A2, B3, C1)
        22: (A2, B3, C2)
        23: (A2, B3, C3)
        24: (A2, B3, C4)
    ```

### Using Combination with Sorting

- PHP:

    ```php
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

    // All Combinations of $a1, $a2 and $a3: does not support sorting
    $a1 = ['A1', 'A2', ];
    $a2 = ['B1', 'B2', 'B3', ];
    $a3 = ['C1', 'C2', 'C3', 'C4', ];

    echo "All Combinations of multiple arrays:\n";
    echo sprintf("\tArray1: (%s)\n", implode(', ', $a1));
    echo sprintf("\tArray2: (%s)\n", implode(', ', $a2));
    echo sprintf("\tArray3: (%s)\n", implode(', ', $a3));

    $r = $c->fromArrays([$a1, $a2, $a3, ]);
    $n = strlen((string) count($r));
    echo sprintf("\tThere're %d patterns:\n", count($r));
    foreach ($r as $i => $e) {
        echo sprintf("\t%" . $n . "d: (%s)\n", $i + 1, implode(', ', $e));
    }
    ```

- Result:

    ```
    All Items:
        (A, B, C, D, E)

    All Combinations:
        (A)
        (A, B)
        (A, B, C)
        (A, B, C, D)
        (A, B, C, D, E)
        (A, B, C, E)
        (A, B, D)
        (A, B, D, E)
        (A, B, E)
        (A, C)
        (A, C, D)
        (A, C, D, E)
        (A, C, E)
        (A, D)
        (A, D, E)
        (A, E)
        (B)
        (B, C)
        (B, C, D)
        (B, C, D, E)
        (B, C, E)
        (B, D)
        (B, D, E)
        (B, E)
        (C)
        (C, D)
        (C, D, E)
        (C, E)
        (D)
        (D, E)
        (E)

    All Pairs:
        (A, B)
        (A, C)
        (A, D)
        (A, E)
        (B, C)
        (B, D)
        (B, E)
        (C, D)
        (C, E)
        (D, E)

    All Combinations of 3 elements:
        (A, B, C)
        (A, B, D)
        (A, B, E)
        (A, C, D)
        (A, C, E)
        (A, D, E)
        (B, C, D)
        (B, C, E)
        (B, D, E)
        (C, D, E)

    All Combinations of 3 to 4 elements:
        (A, B, C)
        (A, B, C, D)
        (A, B, C, E)
        (A, B, D)
        (A, B, D, E)
        (A, B, E)
        (A, C, D)
        (A, C, D, E)
        (A, C, E)
        (A, D, E)
        (B, C, D)
        (B, C, D, E)
        (B, C, E)
        (B, D, E)
        (C, D, E)

    All Combinations of multiple arrays:
        Array1: (A1, A2)
        Array2: (B1, B2, B3)
        Array3: (C1, C2, C3, C4)
        There're 24 patterns:
        1: (A1, B1, C1)
        2: (A1, B1, C2)
        3: (A1, B1, C3)
        4: (A1, B1, C4)
        5: (A1, B2, C1)
        6: (A1, B2, C2)
        7: (A1, B2, C3)
        8: (A1, B2, C4)
        9: (A1, B3, C1)
        10: (A1, B3, C2)
        11: (A1, B3, C3)
        12: (A1, B3, C4)
        13: (A2, B1, C1)
        14: (A2, B1, C2)
        15: (A2, B1, C3)
        16: (A2, B1, C4)
        17: (A2, B2, C1)
        18: (A2, B2, C2)
        19: (A2, B2, C3)
        20: (A2, B2, C4)
        21: (A2, B3, C1)
        22: (A2, B3, C2)
        23: (A2, B3, C3)
        24: (A2, B3, C4)
    ```

### Using CombinationGenerator

- PHP:

    ```php
    <?php

    require_once('../vendor/autoload.php');

    use Macocci7\PhpCombination\CombinationGenerator;

    // Create an Instance
    $c = new CombinationGenerator();

    // All Items
    $items = ['A', 'B', 'C', 'D', 'E', ];
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
    ```

- Result:

    ```
    All Items:
        (A, B, C, D, E)

    All Combinations:
        (A, B, C, D, E)
        (A, B, C, D)
        (A, B, C, E)
        (A, B, C)
        (A, B, D, E)
        (A, B, D)
        (A, B, E)
        (A, B)
        (A, C, D, E)
        (A, C, D)
        (A, C, E)
        (A, C)
        (A, D, E)
        (A, D)
        (A, E)
        (A)
        (B, C, D, E)
        (B, C, D)
        (B, C, E)
        (B, C)
        (B, D, E)
        (B, D)
        (B, E)
        (B)
        (C, D, E)
        (C, D)
        (C, E)
        (C)
        (D, E)
        (D)
        (E)

    All Pairs:
        (A, B)
        (A, C)
        (A, D)
        (A, E)
        (B, C)
        (B, D)
        (B, E)
        (C, D)
        (C, E)
        (D, E)

    All Combinations of 3 elements:
        (A, B, C)
        (A, B, D)
        (A, B, E)
        (A, C, D)
        (A, C, E)
        (A, D, E)
        (B, C, D)
        (B, C, E)
        (B, D, E)
        (C, D, E)

    All Combinations of 3 to 4 elements:
        (A, B, C, D)
        (A, B, C, E)
        (A, B, C)
        (A, B, D, E)
        (A, B, D)
        (A, B, E)
        (A, C, D, E)
        (A, C, D)
        (A, C, E)
        (A, D, E)
        (B, C, D, E)
        (B, C, D)
        (B, C, E)
        (B, D, E)
        (C, D, E)

    ```

## Example

- [UseCombination.php](example/UseCombination.php) >> results in [UseCombination.txt](example/UseCombination.txt)
- [UseCombinationSort.php](example/UseCombinationSort.php) >> results in [UseCombinationSort.txt](example/UseCombinationSort.txt)
- [UseCombinationGenerator.php](example/UseCombinationGenerator.php) >> results in [UseCombinationGenerator.txt](example/UseCombinationGenerator.txt)

## LICENSE

[MIT](LICENSE)

***

*Document Created: 2023/11/11*

*Document Updated: 2023/12/18*

Copyright 2023 macocci7
