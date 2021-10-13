<?php

namespace App\Http\Controllers;

use App\Mail\SignInMail;
use App\Models\User;
use App\Rules\EmailMatchesDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;


class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            ['email' => ['required', 'email', 'max:255', 'ends_with:' . config('meme.whitelisted_domains')]],
            ['email.regex' => 'Diese Domain ist leider nicht freigeschaltet.']
        );


        if ($validator->fails()) {
            // TODO revisit this, not sure if this is going to be kept as is
            $whitelist = DB::table('whitelists')->wherePermitted(true)->get()->pluck('email');

            if (!$whitelist->contains($request->input('email'))) {
                return redirect('/')->withErrors($validator);
            }

            $this->createUserAndSendMail($request->input('email'));

            return Inertia::render('LoginSent');
        }


        $validated = $validator->validated();
        $this->createUserAndSendMail($validated['email']);

        return redirect('/login');
    }

    public function createUserAndSendMail($mail)
    {
        $user = User::firstOrCreate(['email' => $mail]);
        $url = URL::temporarySignedRoute('sign-in', now()->addMinutes(30), ['user' => $user->id]);

        Mail::send(new SignInMail($user, $url));
    }

    public function signIn(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $user = User::findOrFail($request->user);
        Auth::login($user);

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
