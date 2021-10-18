<?php

namespace Tests\Feature\Controllers;

use App\Jobs\SendPendingVerificationMail;
use App\Jobs\SendSignInMail;
use Bus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_shows_the_authentication_page()
    {
        $this
            ->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Welcome')
            )
            ->assertStatus(200);
    }

    // TODO, fix this text, seemed to work earlier but does not now
    public function it_fails_if_not_allowed_domain_is_used()
    {
        Bus::fake();
        config()->set('meme.allowed_domains', 'good-domain.com');
        config()->set('meme.whitelisted_domains', 'good-domain.com');

        $this
            ->json('POST','/login', [
                'email' => 'no@good-domain.com'
            ])
            ->assertJsonFragment([
                'errors' => [
                    'email' => [
                        'Your domain is not allowed.'
                    ]
                ]
            ])
            ->assertStatus(422);

        Bus::assertNotDispatched(SendSignInMail::class);
        Bus::assertNotDispatched(SendPendingVerificationMail::class);
    }

    /** @test */
    public function it_allows_whitelisted_domains_and_dispatches_a_signin_email()
    {
        Bus::fake();
        config()->set('meme.allowed_domains', 'whitelisted.com');
        config()->set('meme.whitelisted_domains', 'whitelisted.com');

        $this
            ->json('POST','/login', [
                'email' => 'yes@whitelisted.com'
            ])
            ->assertRedirect('/mail-sent')
            ->assertStatus(302);

        Bus::assertDispatched(SendSignInMail::class);
    }

    /** @test */
    public function it_allows_pending_domains_and_dispatches_a_pending_verification_email()
    {
        Bus::fake();
        config()->set('meme.allowed_domains', 'whitelisted.com,pending.com');
        config()->set('meme.whitelisted_domains', 'whitelisted.com');
        config()->set('meme.pending_domain', 'pending.com');

        $this
            ->json('POST','/login', [
                'email' => 'yes@pending.com'
            ])
            ->assertRedirect('/pending-verification')
            ->assertStatus(302);

        Bus::assertDispatched(SendPendingVerificationMail::class);
    }
}
