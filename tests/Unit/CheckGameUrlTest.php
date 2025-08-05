<?php

namespace Tests\Unit;

use App\Actions\CheckGameUrl;
use App\Models\GameUrl;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class CheckGameUrlTest extends TestCase
{
    public function test_expired_urls()
    {
        $this->expectException(ModelNotFoundException::class);

        $gameUrl = new GameUrl;
        $gameUrl->expires_at = Carbon::now()->subSecond();
        $checkGameUrl = new CheckGameUrl;
        $checkGameUrl($gameUrl);
    }

    public function test_valid_urls()
    {
        $this->expectNotToPerformAssertions();

        $gameUrl = new GameUrl;
        $gameUrl->expires_at = Carbon::now()->addSecond(1);
        $checkGameUrl = new CheckGameUrl;
        $checkGameUrl($gameUrl);
    }
}
