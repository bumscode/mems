<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    private CreateNewUser $userService;

    public function __construct(CreateNewUser $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        return redirect($this->userService->create($request));
    }


    public function signIn(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        Auth::login(User::findOrFail($request->user));

        return redirect('/memes');
    }
}
