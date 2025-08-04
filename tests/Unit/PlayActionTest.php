<?php

namespace Tests\Unit;

use App\Actions\Play;
use App\Actions\RetrieveGame;
use App\Enums\Outcome;
use App\Helpers\RandomInt;
use App\Models\GameUrl;
use App\Models\Result;
use DG\BypassFinals;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use Random\RandomException;
use RuntimeException;
use Tests\TestCase;

class PlayActionTest extends TestCase
{
    use RefreshDatabase;

    private GameUrl $gameUrl;

    private RandomInt $randomInt;

    private Play $playAction;

    protected function setUp(): void
    {
        parent::setUp();
        BypassFinals::enable(bypassReadOnly: false);

        $this->gameUrl = GameUrl::factory()->create();

        $this->randomInt = $this->getMockBuilder(RandomInt::class)
            ->getMock();

        $this->playAction = new Play($this->randomInt);
    }

    /**
     * @throws RandomException
     */
    public function test_result_saved(): void
    {
        $this->randomInt->expects($this->once())
            ->method('__invoke')
            ->willReturn(10);

        $result = $this->playAction->__invoke($this->gameUrl);

        $this->assertEquals($this->gameUrl->game->id, $result->game_id);
        $this->assertDatabaseHas(
            Result::class,
            [
                'id' => $result->id,
                'game_id' => $this->gameUrl->game->id,
            ],
        );
    }

    /**
     * @throws RandomException
     * @throws Exception
     */
    #[DataProvider('playResults')]
    public function test_play_results(int $randomNumber, Outcome $outcome, float $amount): void
    {
        $this->randomInt->expects($this->once())
            ->method('__invoke')
            ->willReturn($randomNumber);

        $result = $this->playAction->__invoke($this->gameUrl);

        $this->assertEquals($outcome, $result->outcome);
        $this->assertEquals($amount, $result->amount);
    }

    public static function playResults(): array
    {
        return [
            ['randomNumber' => 1, 'outcome' => Outcome::LOSE, 'amount' => 0],
            ['randomNumber' => 901, 'outcome' => Outcome::LOSE, 'amount' => 0],
            ['randomNumber' => 902, 'outcome' => Outcome::WIN, 'amount' => 631.4],
            ['randomNumber' => 910, 'outcome' => Outcome::WIN, 'amount' => 637],
            ['randomNumber' => 601, 'outcome' => Outcome::LOSE, 'amount' => 0],
            ['randomNumber' => 602, 'outcome' => Outcome::WIN, 'amount' => 301],
            ['randomNumber' => 610, 'outcome' => Outcome::WIN, 'amount' => 305],
            ['randomNumber' => 601, 'outcome' => Outcome::LOSE, 'amount' => 0],
            ['randomNumber' => 602, 'outcome' => Outcome::WIN, 'amount' => 301],
            ['randomNumber' => 610, 'outcome' => Outcome::WIN, 'amount' => 305],
            ['randomNumber' => 301, 'outcome' => Outcome::LOSE, 'amount' => 0],
            ['randomNumber' => 302, 'outcome' => Outcome::WIN, 'amount' => 90.6],
            ['randomNumber' => 310, 'outcome' => Outcome::WIN, 'amount' => 93],
            ['randomNumber' => 201, 'outcome' => Outcome::LOSE, 'amount' => 0],
            ['randomNumber' => 160, 'outcome' => Outcome::WIN, 'amount' => 16],
            ['randomNumber' => 86, 'outcome' => Outcome::WIN, 'amount' => 8.6],
        ];
    }

    /**
     * @throws RandomException
     */
    #[DataProvider('wrongNumbers')]
    public function test_wrong_numbers(int $randomNumber): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Number must be between 1 and 1000');

        $this->randomInt->expects($this->once())
            ->method('__invoke')
            ->willReturn($randomNumber);

        $this->playAction->__invoke($this->gameUrl);

    }

    public static function wrongNumbers(): array
    {
        return [
            ['randomNumber' => 0],
            ['randomNumber' => -2],
            ['randomNumber' => 1002],
            ['randomNumber' => 1100],
        ];
    }
}
