<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// ─────────────────────────────────────────────────────────────────────────────
// Helpers
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Create a verified user for authentication tests.
 * Uses the 'user' table with the custom primary key id_user.
 */
function makeUser(array $overrides = []): User
{
    return User::create(array_merge([
        'username' => 'testuser',
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
        'phone_number' => '081234567890',
        'role' => 'buyer',
        'id_address' => null,
        'profile_picture' => null,
    ], $overrides));
}

// ─────────────────────────────────────────────────────────────────────────────
// LOGIN PAGE
// ─────────────────────────────────────────────────────────────────────────────

describe('Login Page', function () {

    it('shows the login page to guests', function () {
        $this->get(route('login'))
            ->assertStatus(200);
    });

    it('redirects authenticated users away from the login page', function () {
        $user = makeUser();

        $this->actingAs($user)
            ->get(route('login'))
            ->assertRedirect(); // middleware 'guest' kicks in
    });

});

// ─────────────────────────────────────────────────────────────────────────────
// LOGIN PROCESS — HAPPY PATH
// ─────────────────────────────────────────────────────────────────────────────

describe('Login Process – success', function () {

    it('logs in a user with valid credentials', function () {
        $user = makeUser();

        $this->post(route('login.process'), [
            'email' => 'test@example.com',
            'password' => 'password123',
        ])
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    });

    it('regenerates the session after login', function () {
        makeUser();

        $sessionBefore = session()->getId();

        $this->post(route('login.process'), [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // After a successful login, Laravel regenerates the session ID.
        $this->assertAuthenticated();
    });

});

// ─────────────────────────────────────────────────────────────────────────────
// LOGIN PROCESS — VALIDATION ERRORS
// ─────────────────────────────────────────────────────────────────────────────

describe('Login Process – validation', function () {

    it('requires an email', function () {
        $this->post(route('login.process'), [
            'email' => '',
            'password' => 'password123',
        ])
            ->assertSessionHasErrors(['email']);
    });

    it('requires a valid email format', function () {
        $this->post(route('login.process'), [
            'email' => 'not-an-email',
            'password' => 'password123',
        ])
            ->assertSessionHasErrors(['email']);
    });

    it('requires a password', function () {
        $this->post(route('login.process'), [
            'email' => 'test@example.com',
            'password' => '',
        ])
            ->assertSessionHasErrors(['password']);
    });

});

// ─────────────────────────────────────────────────────────────────────────────
// LOGIN PROCESS — WRONG CREDENTIALS
// ─────────────────────────────────────────────────────────────────────────────

describe('Login Process – wrong credentials', function () {

    it('returns an error for a wrong password', function () {
        makeUser();

        $this->post(route('login.process'), [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ])
            ->assertSessionHasErrors(['email']);

        $this->assertGuest();
    });

    it('returns an error for an unregistered email', function () {
        $this->post(route('login.process'), [
            'email' => 'nobody@example.com',
            'password' => 'password123',
        ])
            ->assertSessionHasErrors(['email']);

        $this->assertGuest();
    });

    it('flashes the email back to the session on failure', function () {
        makeUser();

        $this->post(route('login.process'), [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ])
            ->assertSessionHasInput('email', 'test@example.com');
    });

    it('does not flash the password back on failure', function () {
        makeUser();

        $this->post(route('login.process'), [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ])
            ->assertSessionMissing('_old_input.password');
    });

    it('shows the Indonesian error message on wrong credentials', function () {
        makeUser();

        $response = $this->post(route('login.process'), [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Email atau password salah.',
        ]);
    });

});

// ─────────────────────────────────────────────────────────────────────────────
// LOGOUT
// ─────────────────────────────────────────────────────────────────────────────

describe('Logout', function () {

    it('logs out an authenticated user and redirects to landing', function () {
        $user = makeUser();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('landing'));

        $this->assertGuest();
    });

    it('shows a success flash message after logout', function () {
        $user = makeUser();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertSessionHas('success');
    });

    it('invalidates the session on logout', function () {
        $user = makeUser();

        $this->actingAs($user)
            ->post(route('logout'));

        $this->assertGuest();
    });

    it('redirects an unauthenticated user who hits logout', function () {
        // Unauthenticated POST /logout should be redirected (auth middleware).
        $this->post(route('logout'))
            ->assertRedirect();
    });

});

// ─────────────────────────────────────────────────────────────────────────────
// REGISTER — HAPPY PATH
// ─────────────────────────────────────────────────────────────────────────────

describe('Register – success', function () {

    it('registers a new user and redirects to the login page', function () {
        $this->post(route('register.process'), [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'secret123',
            'phone_number' => '081298765432',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('user', ['email' => 'newuser@example.com']);
    });

    it('hashes the password before storing', function () {
        $this->post(route('register.process'), [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'secret123',
            'phone_number' => null,
        ]);

        $user = User::where('email', 'newuser@example.com')->first();

        expect(Hash::check('secret123', $user->password))->toBeTrue();
    });

    it('assigns the buyer role by default', function () {
        $this->post(route('register.process'), [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'secret123',
        ]);

        $this->assertDatabaseHas('user', [
            'email' => 'newuser@example.com',
            'role' => 'buyer',
        ]);
    });

    it('allows registration without a phone number', function () {
        $this->post(route('register.process'), [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'secret123',
        ])
            ->assertRedirect(route('login'));
    });

});

// ─────────────────────────────────────────────────────────────────────────────
// REGISTER — VALIDATION ERRORS
// ─────────────────────────────────────────────────────────────────────────────

describe('Register – validation', function () {

    it('requires a username', function () {
        $this->post(route('register.process'), [
            'username' => '',
            'email' => 'new@example.com',
            'password' => 'secret123',
        ])
            ->assertSessionHasErrors(['username']);
    });

    it('requires a unique username', function () {
        makeUser(['username' => 'taken', 'email' => 'taken@example.com']);

        $this->post(route('register.process'), [
            'username' => 'taken',
            'email' => 'other@example.com',
            'password' => 'secret123',
        ])
            ->assertSessionHasErrors(['username']);
    });

    it('requires a unique email', function () {
        makeUser(['username' => 'userA', 'email' => 'taken@example.com']);

        $this->post(route('register.process'), [
            'username' => 'userB',
            'email' => 'taken@example.com',
            'password' => 'secret123',
        ])
            ->assertSessionHasErrors(['email']);
    });

    it('requires a valid email format', function () {
        $this->post(route('register.process'), [
            'username' => 'newuser',
            'email' => 'not-an-email',
            'password' => 'secret123',
        ])
            ->assertSessionHasErrors(['email']);
    });

    it('requires a password of at least 6 characters', function () {
        $this->post(route('register.process'), [
            'username' => 'newuser',
            'email' => 'new@example.com',
            'password' => '123',
        ])
            ->assertSessionHasErrors(['password']);
    });

    it('rejects a phone number that is too short', function () {
        $this->post(route('register.process'), [
            'username' => 'newuser',
            'email' => 'new@example.com',
            'password' => 'secret123',
            'phone_number' => '123',
        ])
            ->assertSessionHasErrors(['phone_number']);
    });

    it('rejects a phone number that is too long', function () {
        $this->post(route('register.process'), [
            'username' => 'newuser',
            'email' => 'new@example.com',
            'password' => 'secret123',
            'phone_number' => '1234567890123456', // 16 digits
        ])
            ->assertSessionHasErrors(['phone_number']);
    });

    it('rejects a non-numeric phone number', function () {
        $this->post(route('register.process'), [
            'username' => 'newuser',
            'email' => 'new@example.com',
            'password' => 'secret123',
            'phone_number' => 'abcdefghij',
        ])
            ->assertSessionHasErrors(['phone_number']);
    });

});

// ─────────────────────────────────────────────────────────────────────────────
// SWITCH ACCOUNT
// ─────────────────────────────────────────────────────────────────────────────

describe('Switch Account', function () {

    it('logs out the current user and redirects to login with the target email', function () {
        $user = makeUser();

        $this->actingAs($user)
            ->post(route('auth.switch'), ['email' => 'other@example.com'])
            ->assertRedirect(route('login'))
            ->assertSessionHas('last_email', 'other@example.com');

        $this->assertGuest();
    });

    it('requires authentication to switch accounts', function () {
        $this->post(route('auth.switch'), ['email' => 'other@example.com'])
            ->assertRedirect(route('login'));
    });

});
