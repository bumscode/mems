<?php

namespace App\Actions\Fortify;

use App\Jobs\SendPendingVerificationMail;
use App\Jobs\SendSignInMail;
use App\Mail\PendingVerificationMail;
use App\Mail\SignInMail;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Jetstream;

class CreateNewUser
{
    use PasswordValidationRules;

    public function create(Request $request)
    {
        /*
         * TODO should only go through this journey if the email is not whitelisted in DB
         * aka emails that are pending are whitelisted and are no longer pending
         */
        $validated = Validator::make($request->all(), [
            //'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'email' => ['required', 'string', 'email', 'max:255', 'ends_with:'.config('meme.allowed_domains')],
        ], [
            'email.ends_with' => 'Your domain is not allowed.',
        ])->validate();

        $emailDomain = substr(strstr($validated['email'], '@'), 1);

        $isWhitelisted = in_array(
            $emailDomain, Str::of(config('meme.whitelisted_domains'))->explode(',')->toArray()
        );

        if (!$isWhitelisted) {
            $user = $this->createUserAndAddToTeam($validated['email']);
            $this->sendPendingVerificationMail($user->email);

            return 'pending-verification';
        }

        $user = $this->createUserAndAddToTeam($validated['email'], true);
        $this->sendLoginMail($user);

        return 'mail-sent';
    }

    /**
     * Create a personal team for the user.
     *
     * @param  User  $user
     * @return void
     */
    protected function joinTeam(User $user): void
    {
        $team = Team::first();

        $user->teams()->attach($team);

        $user->switchTeam($team);
    }

    private function createUserAndAddToTeam(string $email, bool $isWhitelisted = false): User
    {
        return DB::transaction(function () use ($email, $isWhitelisted) {
            return tap(User::firstOrCreate([
                'email' => $email,
                'whitelisted' => $isWhitelisted
            ]), function (User $user) {
                if (is_null($user->current_team_id)) {
                    $this->joinTeam($user);
                }
            });
        });
    }

    private function sendPendingVerificationMail(string $userEmail)
    {
        SendPendingVerificationMail::dispatch(
            config('meme.admin_email'),
            $userEmail
        );
    }

    private function sendLoginMail(User $user)
    {
        SendSignInMail::dispatch(
            $user->email,
            URL::temporarySignedRoute(
                'sign-in',
                now()->addMinutes(30),
                ['user' => $user->id]
            )
        );
    }
}
