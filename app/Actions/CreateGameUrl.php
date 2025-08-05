<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Game;
use App\Models\GameUrl;
use Carbon\Carbon;

final readonly class CreateGameUrl
{
    private const EXPIRE_AFTER_DAYS = 7;

    public function __invoke(Game $game)
    {
        return GameUrl::create([
            'game_id' => $game->id,
            'expires_at' => Carbon::now()->addDays(self::EXPIRE_AFTER_DAYS),
        ]);
    }
}
