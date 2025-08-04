<?php

namespace App\Http\Controllers;

use App\Actions\CheckAccessToken;
use App\Actions\CreateAccessToken;
use App\Actions\DeactivateAccessToken;
use App\Actions\Play;
use App\Actions\RetrieveHistory;
use App\Actions\RetrieveResult;
use App\Models\AccessToken;
use Random\RandomException;

class GamesController extends Controller
{
    public function index(AccessToken $accessToken, CheckAccessToken $checkAccessToken)
    {
        $checkAccessToken($accessToken);

        return view('game/index', ['accessToken' => $accessToken->id]);
    }

    public function create(AccessToken $accessToken, CreateAccessToken $createAccessToken)
    {
        $newAccessToken = $createAccessToken($accessToken);

        return redirect()->action(
            [GamesController::class, 'index'],
            ['accessToken' => $newAccessToken->id],
        );
    }

    public function deactivate(AccessToken $accessToken, DeactivateAccessToken $deactivateAccessToken)
    {
        $deactivateAccessToken($accessToken);

        return redirect('/');
    }

    /**
     * @throws RandomException
     */
    public function play(AccessToken $accessToken, Play $play)
    {
        $result = $play($accessToken);

        return redirect()->action(
            [GamesController::class, 'result'],
            [
                'accessToken' => $accessToken->id,
                'resultId' => $result->id,
            ],
        );
    }

    public function result(AccessToken $accessToken, string $resultId, RetrieveResult $retrieveResult)
    {
        $result = $retrieveResult($accessToken, $resultId);

        return view(
            'game/result',
            [
                'accessToken' => $accessToken->id,
                'result' => $result,
            ],
        );
    }

    public function history(AccessToken $accessToken, RetrieveHistory $retrieveHistory)
    {
        $results = $retrieveHistory($accessToken);

        return view(
            'game/history',
            [
                'accessToken' => $accessToken->id,
                'latestResults' => $results,
            ],
        );
    }
}
