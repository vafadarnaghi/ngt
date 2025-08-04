<?php

namespace App\Http\Controllers;

use App\Actions\CheckGameUrl;
use App\Actions\CreateGameUrl;
use App\Actions\DeactivateGameUrl;
use App\Actions\Play;
use App\Actions\RetrieveHistory;
use App\Actions\RetrieveResult;
use App\Models\GameUrl;
use Random\RandomException;

class GamesController extends Controller
{
    public function index(GameUrl $gameUrl, CheckGameUrl $checkGameUrl)
    {
        $checkGameUrl($gameUrl);

        return view('game/index', ['gameUrl' => $gameUrl->id]);
    }

    public function create(GameUrl $gameUrl, CreateGameUrl $createGameUrl)
    {
        $newGameUrl = $createGameUrl($gameUrl);

        return redirect()->route(
            'game.index',
            ['gameUrl' => $newGameUrl->id],
        );
    }

    public function deactivate(GameUrl $gameUrl, DeactivateGameUrl $deactivateGameUrl)
    {
        $deactivateGameUrl($gameUrl);

        return redirect('/');
    }

    /**
     * @throws RandomException
     */
    public function play(GameUrl $gameUrl, Play $play)
    {
        $result = $play($gameUrl);

        return redirect()->route(
            'game.result',
            [
                'gameUrl' => $gameUrl->id,
                'resultId' => $result->id,
            ],
        );
    }

    public function result(GameUrl $gameUrl, string $resultId, RetrieveResult $retrieveResult)
    {
        $result = $retrieveResult($gameUrl, $resultId);

        return view(
            'game/result',
            [
                'gameUrl' => $gameUrl->id,
                'result' => $result,
            ],
        );
    }

    public function history(GameUrl $gameUrl, RetrieveHistory $retrieveHistory)
    {
        $results = $retrieveHistory($gameUrl);

        return view(
            'game/history',
            [
                'gameUrl' => $gameUrl->id,
                'latestResults' => $results,
            ],
        );
    }
}
