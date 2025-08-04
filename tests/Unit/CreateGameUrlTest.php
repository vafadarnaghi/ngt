<?php

namespace Tests\Unit;

use App\Actions\CreateGameUrl;
use App\Models\User;
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

        $user = User::factory()->create();

        $createGameUrl = new CreateGameUrl();

        $gameUrl = $createGameUrl($user);

        $this->assertEquals($expiresAt, $gameUrl->expires_at);

        Carbon::setTestNow();
    }
}
