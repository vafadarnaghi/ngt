<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\Outcome;
use App\Helpers\RandomInt;
use App\Models\GameUrl;
use App\Models\Result;
use Random\RandomException;
use RuntimeException;

final readonly class Play
{
    private const MIN_RANDOM_NUMBER = 1;

    private const MAX_RANDOM_NUMBER = 1000;

    public function __construct(
        private RetrieveGame $retrieveGame,
        private RandomInt $randomInt,
    ) {}

    /**
     * @throws RandomException
     */
    public function __invoke(GameUrl $gameUrl): Result
    {
        $game = $this->retrieveGame->__invoke($gameUrl);

        $number = $this->randomInt->__invoke(self::MIN_RANDOM_NUMBER, self::MAX_RANDOM_NUMBER);
        if ($number < self::MIN_RANDOM_NUMBER || $number > self::MAX_RANDOM_NUMBER) {
            throw new RuntimeException('Number must be between 1 and 1000');
        }

        return Result::create([
            'game_id' => $game->id,
            'outcome' => $this->analyzeOutcome($number),
            'amount' => $this->analyzeAmount($number),
        ]);
    }

    private function analyzeOutcome(int $number): Outcome
    {
        return $number % 2 === 0
            ? Outcome::WIN
            : Outcome::LOSE;
    }

    private function analyzeAmount(int $number): float
    {
        $amount = 0;
        if ($this->analyzeOutcome($number) === Outcome::WIN) {
            $amount = match (true) {
                $number > 900 => $number * 0.7,
                $number > 600 => $number * 0.5,
                $number > 300 => $number * 0.3,
                default => $number * 0.1 ,
            };
        }

        return round($amount, 2);
    }
}
