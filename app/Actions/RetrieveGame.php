<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\AccessToken;
use App\Models\Game;

final readonly class RetrieveGame
{
    public function __construct(
        private CheckAccessToken $checkAccessToken,
    ) {}

    public function handle(AccessToken $accessToken): Game
    {
        $this->checkAccessToken->hande($accessToken);

        return $accessToken->game;
    }
}
