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

    public function __construct(
        private RetrieveGame $retrieveGame,
    ) {}

    public function __invoke(User|GameUrl $source)
    {
        if ($source instanceof User) {
            $userId = $source->id;
        } else {
            $userId = $this->retrieveGame->__invoke($source)->user_id;
        }

        $newGame = Game::create(['user_id' => $userId]);

        return GameUrl::create([
            'game_id' => $newGame->id,
            'expires_at' => Carbon::now()->addDays(self::EXPIRE_AFTER_DAYS),
        ]);
    }
}
