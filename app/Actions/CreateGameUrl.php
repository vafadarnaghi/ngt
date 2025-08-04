<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Game;
use App\Models\GameUrl;
use App\Models\User;
use Carbon\Carbon;

final readonly class CreateGameUrl
{
    private const EXPIRE_AFTER_DAYS = 7;

    public function __invoke(User $user)
    {
        $newGame = Game::create(['user_id' => $user->id]);

        return GameUrl::create([
            'game_id' => $newGame->id,
            'expires_at' => Carbon::now()->addDays(self::EXPIRE_AFTER_DAYS),
        ]);
    }
}
