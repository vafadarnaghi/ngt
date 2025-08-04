<?php

namespace Database\Factories;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameUrl>
 */
class GameUrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_id' => Game::factory()->create(),
            'expires_at' => Carbon::now(),
        ];
    }
}
