<?php

namespace App\Http\Controllers;

use App\Actions\CreateGameUrl;
use App\Actions\DeactivateGameUrl;
use App\Actions\Play;
use App\Actions\RetrieveHistory;
use App\Actions\RetrieveResult;
use App\Models\GameUrl;
use App\Models\Result;
use Random\RandomException;

class GamesController extends Controller
{
    public function index(GameUrl $gameUrl)
    {
        return view('game/index', ['gameUrl' => $gameUrl]);
    }

    public function create(GameUrl $gameUrl, CreateGameUrl $createGameUrl)
    {
        $newGameUrl = $createGameUrl($gameUrl->user);

        return redirect()->route(
            'game.index',
            ['gameUrl' => $newGameUrl],
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

        return view(
            'game/result',
            [
                'gameUrl' => $gameUrl,
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
                'gameUrl' => $gameUrl,
                'latestResults' => $results,
            ],
        );
    }
}
