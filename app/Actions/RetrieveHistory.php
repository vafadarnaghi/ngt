<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\AccessToken;
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
    public function handle(AccessToken $accessToken): Collection
    {
        return $this->retrieveGame
            ->handle($accessToken)
            ->results()
            ->orderByDesc('created_at')
            ->limit(self::HISTORY_COUNT)
            ->get();
    }
}
