# PHP-Combination

A simple PHP library to make combinations from array elements.

## Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Example](#example)
- [LICENSE](#license)

## Requirements

- PHP 8.0.0 (CLI) or later
- Composer

## Installation

```bash
composer require macocci7/php-combination
```

## Usage

- PHP:

    ```php
    <?php

    require_once('../vendor/autoload.php');

    use Macocci7\PhpCombination\Combination;

    // Create an Instance
    $c = new Combination();

    // All Items
    $items = ['A', 'B', 'C', 'D', 'E', ];
    echo sprintf("All Items:\n\t(%s)\n\n", implode(",", $items));

    // Call back
    $f = function (array $array): string {
        return sprintf("(%s)", implode(', ', $array));
    };

    // All Combinations
    echo sprintf(
        "All Combinations:\n\t%s\n\n",
        implode(",\n\t", array_map($f, $c->all($items)))
    );

    // All Pairs
    echo sprintf(
        "All Pairs:\n\t%s\n\n",
        implode(",\n\t", array_map($f, $c->pairs($items)))
    );

    // All Combinations of $n elements
    $n = 3;
    echo sprintf(
        "All Combinations of %d elements:\n\t%s\n\n",
        $n,
        implode(",\n\t", array_map($f, $c->ofN($items, $n)))
    );

    ```

- Result:

    ```
    All Items:
        (A,B,C,D,E)

    All Combinations:
        (E),
        (D),
        (D, E),
        (C),
        (C, E),
        (C, D),
        (C, D, E),
        (B),
        (B, E),
        (B, D),
        (B, D, E),
        (B, C),
        (B, C, E),
        (B, C, D),
        (B, C, D, E),
        (A),
        (A, E),
        (A, D),
        (A, D, E),
        (A, C),
        (A, C, E),
        (A, C, D),
        (A, C, D, E),
        (A, B),
        (A, B, E),
        (A, B, D),
        (A, B, D, E),
        (A, B, C),
        (A, B, C, E),
        (A, B, C, D),
        (A, B, C, D, E)

    All Pairs:
        (A, B),
        (A, C),
        (A, D),
        (A, E),
        (B, C),
        (B, D),
        (B, E),
        (C, D),
        (C, E),
        (D, E)

    All Combinations of 3 elements:
        (C, D, E),
        (B, D, E),
        (B, C, E),
        (B, C, D),
        (A, D, E),
        (A, C, E),
        (A, C, D),
        (A, B, E),
        (A, B, D),
        (A, B, C)
    ```

## Example

- [UseCombination.php](example/UseCombination.php) >> results in [UseCombination.txt](example/UseCombination.txt)

## LICENSE

[MIT](LICENSE)

***

*Document Created: 2023/11/11*

*Document Updated: 2023/11/11*

Copyright 2023 macocci7
