<?php

namespace Tests;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createUserAndTeam();
    }

    private function createUserAndTeam(): void
    {
        User::factory()
            ->hasAttached(
                Team::factory()
                    ->state(function (array $attributes, User $user) {
                        return ['user_id' => $user->id, 'personal_team' => true];
                    }),
                )
            ->create();
    }
}
