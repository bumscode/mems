<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param array $input
     * @return User
     * @throws ValidationException
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
            ]), function (User $user) {
                $this->joinTeam($user);
            });
        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param User $user
     * @return void
     */
    protected function joinTeam(User $user): void
    {
        $team = Team::first();

        $user->teams()->attach($team);

        $user->switchTeam($team);
    }
}
