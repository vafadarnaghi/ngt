<?php

namespace App\Enums;

enum Outcome: string
{
    case WIN = 'win';
    case LOSE = 'lose';

    public function label(): string
    {
        return match ($this) {
            self::WIN => 'Win',
            self::LOSE => 'Lose',
        };
    }
}
