<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Game;
use App\Models\GameUrl;

final readonly class RetrieveGame
{
    public function __construct(
        private CheckGameUrl $checkGameUrl,
    ) {}

    public function __invoke(GameUrl $gameUrl): Game
    {
        $this->checkGameUrl->__invoke($gameUrl);

        return $gameUrl->game;
    }
}
