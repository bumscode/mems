<?php

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            return tap(User::create([
                'email' => config('meme.admin_email'),
                'whitelisted' => true
            ]), function (User $user) {
                $team = Team::create([
                    'user_id' => 1,
                    'name' => 'members',
                    'personal_team' => false
                ]);

                $user->teams()->attach($team);

                $user->switchTeam($team);
            });
        });
    }
}
