<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\GameUrl;
use App\Models\Result;
use Illuminate\Validation\UnauthorizedException;

final readonly class RetrieveResult
{
    public function __invoke(GameUrl $gameUrl, Result $result): Result
    {
        if ($result->game_id !== $gameUrl->game->id) {
            throw new UnauthorizedException;
        }

        return $result;
    }
}
