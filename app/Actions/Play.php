<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\Outcome;
use App\Models\AccessToken;
use App\Models\Result;
use Random\RandomException;
use RuntimeException;

final readonly class Play
{
    private const MIN_RANDOM_NUMBER = 1;

    private const MAX_RANDOM_NUMBER = 1000;

    public function __construct(
        private RetrieveGame $retrieveGame,
    ) {}

    /**
     * @throws RandomException
     */
    public function __invoke(AccessToken $accessToken): Result
    {
        $game = $this->retrieveGame->__invoke($accessToken);

        $number = $this->generateNumber();
        if ($number < self::MIN_RANDOM_NUMBER || $number > self::MAX_RANDOM_NUMBER) {
            throw new RuntimeException('Number must be between 1 and 1000');
        }

        $outcome = Outcome::LOSE;
        $amount = 0;
        if ($number % 2 === 0) {
            $outcome = Outcome::WIN;
        }

        if ($outcome === Outcome::WIN) {
            $amount = match (true) {
                $number > 900 => $number * 0.7,
                $number > 600 => $number * 0.5,
                $number > 300 => $number * 0.3,
                default => $number * 0.1 ,
            };
        }

        $amount = round($amount, 2);

        return Result::create([
            'game_id' => $game->id,
            'outcome' => $outcome,
            'amount' => $amount,
        ]);
    }

    /**
     * @throws RandomException
     */
    protected function generateNumber(): int
    {
        return random_int(self::MIN_RANDOM_NUMBER, self::MAX_RANDOM_NUMBER);
    }
}
