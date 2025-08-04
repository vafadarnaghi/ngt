<?php

namespace Tests\Unit;

use App\Actions\Play;
use App\Actions\RetrieveGame;
use App\Enums\Outcome;
use App\Models\AccessToken;
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

    private AccessToken $accessToken;

    private Play $playActionMock;

    protected function setUp(): void
    {
        parent::setUp();
        BypassFinals::enable(bypassReadOnly: false);

        $this->accessToken = AccessToken::factory()->create();

        $retrieveGameAction = $this->getMockBuilder(RetrieveGame::class)
            ->disableOriginalConstructor()
            ->getMock();
        $retrieveGameAction->expects($this->once())
            ->method('__invoke')
            ->willReturn($this->accessToken->game);

        $this->playActionMock = $this->getMockBuilder(Play::class)
            ->setConstructorArgs([$retrieveGameAction])
            ->onlyMethods(['generateNumber'])
            ->getMock();
    }

    /**
     * @throws RandomException
     */
    public function test_result_saved(): void
    {
        $this->playActionMock->expects($this->once())
            ->method('generateNumber')
            ->willReturn(10);

        $result = $this->playActionMock->__invoke($this->accessToken);

        $this->assertEquals($this->accessToken->game->id, $result->game_id);
        $this->assertDatabaseHas(
            Result::class,
            [
                'id' => $result->id,
                'game_id' => $this->accessToken->game->id,
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
        $this->playActionMock->expects($this->once())
            ->method('generateNumber')
            ->willReturn($randomNumber);

        $result = $this->playActionMock->__invoke($this->accessToken);

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

        $this->playActionMock->expects($this->once())
            ->method('generateNumber')
            ->willReturn($randomNumber);

        $this->playActionMock->__invoke($this->accessToken);

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
