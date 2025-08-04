<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\GameUrl;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class CheckGameUrl
{
    public function __invoke(GameUrl $gameUrl): void
    {
        if (Carbon::now() > $gameUrl->expires_at) {
            throw new ModelNotFoundException;
        }
    }
}
