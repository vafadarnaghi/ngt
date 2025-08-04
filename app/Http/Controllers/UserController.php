<?php

namespace App\Http\Controllers;

use App\Actions\CreateAccessToken;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;

class UserController extends Controller
{
    public function register()
    {
        return view('users/register');
    }

    public function create(UserRegistrationRequest $request, CreateAccessToken $createAccessToken)
    {
        $newUser = User::create($request->validated());

        $accessToken = $createAccessToken($newUser);

        return redirect()->route(
            'game.index',
            ['accessToken' => $accessToken->id],
        );
    }
}
