<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\GameUrl;

final readonly class DeactivateGameUrl
{
    public function __construct(
        private CheckGameUrl $checkGameUrln,
    ) {}

    public function __invoke(GameUrl $gameUrl): void
    {
        $this->checkGameUrln->__invoke($gameUrl);
        $gameUrl->delete();
    }
}
