<?php

namespace App\Http\Controllers;

use App\Actions\CreateGameUrl;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;

class UserController extends Controller
{
    public function register()
    {
        return view('users/register');
    }

    public function create(UserRegistrationRequest $request, CreateGameUrl $createGameUrl)
    {
        $newUser = User::create($request->validated());

        $gameUrl = $createGameUrl($newUser);

        return redirect()->route(
            'game.index',
            ['gameUrl' => $gameUrl],
        );
    }
}
