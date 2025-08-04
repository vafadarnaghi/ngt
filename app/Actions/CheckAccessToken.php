<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\AccessToken;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class CheckAccessToken
{
    public function hande(AccessToken $accessToken): void
    {
        if (Carbon::now() > $accessToken->expires_at) {
            throw new ModelNotFoundException;
        }
    }
}
