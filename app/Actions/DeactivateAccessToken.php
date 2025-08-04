<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\AccessToken;

final readonly class DeactivateAccessToken
{
    public function __construct(
        private CheckAccessToken $checkAccessToken,
    ) {}

    public function __invoke(AccessToken $accessToken): void
    {
        $this->checkAccessToken->__invoke($accessToken);
        $accessToken->delete();
    }
}
