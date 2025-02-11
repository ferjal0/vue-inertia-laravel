<?php

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/account/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/account/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/account/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/account/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/account/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/account/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/account/profile')
        ->delete('/account/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect('/account/profile');

    $this->assertNotNull($user->fresh());
});

test('security page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/account/security');

    $response->assertOk();
});

test('user can destroy other browser sessions', function () {
    Config::set('session.driver', 'database');

    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/account/security')
        ->delete('/account/sessions/other-browser-sessions', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/account/security')
        ->assertSessionHas('status', 'other-browser-sessions-terminated');
});

test('user cannot destroy other browser sessions with wrong password', function () {
    Config::set('session.driver', 'database');

    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/account/security')
        ->delete('/account/sessions/other-browser-sessions', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect('/account/security');
});

test('user can destroy specific browser session', function () {
    Config::set('session.driver', 'database');

    $user = User::factory()->create();

    // Create a test session in the database
    $sessionId = 'test-session-id';
    DB::table('sessions')->insert([
        'id' => $sessionId,
        'user_id' => $user->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Test Agent',
        'payload' => serialize(['_token' => 'test']),
        'last_activity' => time(),
    ]);

    $response = $this
        ->actingAs($user)
        ->from('/account/security')
        ->delete("/account/sessions/browser-sessions/{$sessionId}", [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/account/security')
        ->assertSessionHas('status', 'browser-session-terminated');

    // Verify the session was actually deleted
    $this->assertNull(
        DB::table('sessions')
            ->where('id', $sessionId)
            ->first()
    );
});
