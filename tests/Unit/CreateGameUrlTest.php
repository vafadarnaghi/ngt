<?php

namespace Tests\Unit;

use App\Actions\CreateGameUrl;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateGameUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_url_expires_after_seven_days()
    {
        $knownDate = Carbon::create();
        Carbon::setTestNow($knownDate);

        $expiresAt = Carbon::now()->addDays(7);

        $game = Game::factory()->create();
        $createGameUrl = new CreateGameUrl;
        $gameUrl = $createGameUrl($game);

        $this->assertEquals($expiresAt, $gameUrl->expires_at);

        Carbon::setTestNow();
    }
}
