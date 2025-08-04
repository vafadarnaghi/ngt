<?php

declare(strict_types=1);

namespace App\Helpers;

use Random\RandomException;

class RandomInt
{
    /**
     * @throws RandomException
     */
    public function __invoke(int $min, int $max): int
    {
        return random_int($min, $max);
    }
}
