<?php

namespace App\Models;

use App\Enums\Outcome;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    use HasTimestamps, HasUlids;

    protected $fillable = ['game_id', 'outcome', 'amount'];

    protected function casts(): array
    {
        return [
            'outcome' => Outcome::class,
        ];
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
