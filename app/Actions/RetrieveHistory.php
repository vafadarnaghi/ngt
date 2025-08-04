<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\GameUrl;
use App\Models\Result;
use Illuminate\Support\Collection;

final readonly class RetrieveHistory
{
    private const HISTORY_COUNT = 3;

    /**
     * @return Collection<Result>
     */
    public function __invoke(GameUrl $gameUrl): Collection
    {
        return $gameUrl
            ->game
            ->results()
            ->orderByDesc('created_at')
            ->limit(self::HISTORY_COUNT)
            ->get();
    }
}
