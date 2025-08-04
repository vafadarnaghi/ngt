<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\GameUrl;
use App\Models\Result;
use Illuminate\Support\Collection;

final readonly class RetrieveHistory
{
    private const HISTORY_COUNT = 3;

    public function __construct(
        private RetrieveGame $retrieveGame,
    ) {}

    /**
     * @return Collection<Result>
     */
    public function __invoke(GameUrl $gameUrl): Collection
    {
        return $this->retrieveGame
            ->__invoke($gameUrl)
            ->results()
            ->orderByDesc('created_at')
            ->limit(self::HISTORY_COUNT)
            ->get();
    }
}
