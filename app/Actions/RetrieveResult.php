<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\AccessToken;
use App\Models\Result;
use Illuminate\Validation\UnauthorizedException;

final readonly class RetrieveResult
{
    public function __construct(
        private RetrieveGame $retrieveGame,
    ) {}

    public function __invoke(AccessToken $accessToken, string $resultId): Result
    {
        $game = $this->retrieveGame->__invoke($accessToken);
        $result = Result::findOrFail($resultId);

        if ($result->game_id !== $game->id) {
            throw new UnauthorizedException;
        }

        return $result;
    }
}
