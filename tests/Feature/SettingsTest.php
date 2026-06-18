<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

// ============================================================
// AUTH GUARDS
// ============================================================

it('redirects guests from the profile page', function () {
    $this->get(route('settings.profile'))
        ->assertRedirect(route('login'));
});

it('redirects guests from the password page', function () {
    $this->get(route('settings.password'))
        ->assertRedirect(route('login'));
});

it('redirects guests from the more settings page', function () {
    $this->get(route('settings.more'))
        ->assertRedirect(route('login'));
});

it('redirects guests from the login history page', function () {
    $this->get(route('settings.history'))
        ->assertRedirect(route('login'));
});

it('redirects guests attempting to delete an account', function () {
    $this->delete(route('settings.deleteAccount'))
        ->assertRedirect(route('login'));
});

// ============================================================
// PROFILE VIEW
// ============================================================

it('renders the profile edit page with the authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('settings.profile'))
        ->assertOk()
        ->assertViewIs('settings.profile')
        ->assertViewHas('user', $user);
});

// ============================================================
// UPDATE PROFILE – Happy Path
// ============================================================

it('updates profile fields and redirects with success flash', function () {
    $user = User::factory()->create([
        'username'     => 'oldname',
        'email'        => 'old@test.com',
        'phone_number' => '081000000000',
        'role'         => 'buyer',
    ]);

    $this->actingAs($user)
        ->post(route('settings.updateProfile'), [
            'username'     => 'newname',
            'email'        => 'new@test.com',
            'phone_number' => '089900001111',
            'role'         => 'seller',
        ])
        ->assertRedirect(route('settings.profile'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('user', [
        'id_user'  => $user->id_user,
        'username' => 'newname',
        'email'    => 'new@test.com',
        'role'     => 'seller',
    ]);
});

it('allows the user to retain their own email when updating profile', function () {
    $user = User::factory()->create(['email' => 'mine@test.com']);

    $this->actingAs($user)
        ->post(route('settings.updateProfile'), [
            'username'     => $user->username,
            'email'        => 'mine@test.com',
            'phone_number' => $user->phone_number,
            'role'         => $user->role,
        ])
        ->assertRedirect(route('settings.profile'));
});

// ============================================================
// UPDATE PROFILE – Validation
// ============================================================

it('fails profile update when username is missing', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('settings.updateProfile'), [
            'email'        => $user->email,
            'phone_number' => $user->phone_number,
            'role'         => $user->role,
        ])
        ->assertSessionHasErrors('username');
});

it('fails profile update when email is already taken by another user', function () {
    User::factory()->create(['email' => 'taken@test.com']);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('settings.updateProfile'), [
            'username'     => 'testuser',
            'email'        => 'taken@test.com',
            'phone_number' => '081234567890',
            'role'         => 'buyer',
        ])
        ->assertSessionHasErrors('email');
});

it('fails profile update when role is not buyer or seller', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('settings.updateProfile'), [
            'username'     => 'testuser',
            'email'        => $user->email,
            'phone_number' => '081234567890',
            'role'         => 'admin',
        ])
        ->assertSessionHasErrors('role');
});

it('fails profile update when phone_number contains non-numeric characters', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('settings.updateProfile'), [
            'username'     => 'testuser',
            'email'        => $user->email,
            'phone_number' => '+62-812-xxx',
            'role'         => 'buyer',
        ])
        ->assertSessionHasErrors('phone_number');
});

it('fails profile update when email format is invalid', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('settings.updateProfile'), [
            'username'     => 'testuser',
            'email'        => 'not-an-email',
            'phone_number' => '081234567890',
            'role'         => 'buyer',
        ])
        ->assertSessionHasErrors('email');
});

it('fails profile update when username exceeds 255 characters', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('settings.updateProfile'), [
            'username'     => str_repeat('a', 256),
            'email'        => $user->email,
            'phone_number' => '081234567890',
            'role'         => 'buyer',
        ])
        ->assertSessionHasErrors('username');
});

// ============================================================
// MORE SETTINGS
// ============================================================

it('renders the more settings page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('settings.more'))
        ->assertOk()
        ->assertViewIs('settings.more');
});

// ============================================================
// CHANGE PASSWORD – Page
// ============================================================

it('renders the change password page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('settings.password'))
        ->assertOk()
        ->assertViewIs('settings.password');
});

// ============================================================
// CHANGE PASSWORD – Happy Path
// ============================================================

it('updates password with correct current password and stores the new hash', function () {
    $user = User::factory()->create([
        'password' => Hash::make('OldPass123'),
    ]);

    $this->actingAs($user)
        ->post(route('settings.updatePassword'), [
            'current_password'          => 'OldPass123',
            'new_password'              => 'NewPass456',
            'new_password_confirmation' => 'NewPass456',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Hash::check('NewPass456', $user->fresh()->password))->toBeTrue();
});

// ============================================================
// CHANGE PASSWORD – Validation
// ============================================================

it('fails password change when current password is wrong', function () {
    $user = User::factory()->create([
        'password' => Hash::make('CorrectPass'),
    ]);

    $this->actingAs($user)
        ->post(route('settings.updatePassword'), [
            'current_password'          => 'WrongPass',
            'new_password'              => 'NewPass456',
            'new_password_confirmation' => 'NewPass456',
        ])
        ->assertSessionHasErrors('current_password');
});

it('fails password change when new password is fewer than 6 characters', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user)
        ->post(route('settings.updatePassword'), [
            'current_password'          => 'password',
            'new_password'              => 'abc',
            'new_password_confirmation' => 'abc',
        ])
        ->assertSessionHasErrors('new_password');
});

it('fails password change when confirmation does not match', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user)
        ->post(route('settings.updatePassword'), [
            'current_password'          => 'password',
            'new_password'              => 'NewPass123',
            'new_password_confirmation' => 'DifferentPass',
        ])
        ->assertSessionHasErrors('new_password');
});

it('fails password change when new password is identical to current password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('SamePassword1'),
    ]);

    $this->actingAs($user)
        ->post(route('settings.updatePassword'), [
            'current_password'          => 'SamePassword1',
            'new_password'              => 'SamePassword1',
            'new_password_confirmation' => 'SamePassword1',
        ])
        ->assertSessionHasErrors('new_password');
});

it('fails password change when current_password field is absent', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('settings.updatePassword'), [
            'new_password'              => 'NewPass123',
            'new_password_confirmation' => 'NewPass123',
        ])
        ->assertSessionHasErrors('current_password');
});

// ============================================================
// LOGIN HISTORY
// ============================================================

it('renders login history page with geo-location data on successful API response', function () {
    Http::fake([
        'http://ip-api.com/json/' => Http::response([
            'status'  => 'success',
            'city'    => 'Surabaya',
            'country' => 'Indonesia',
            'query'   => '103.148.0.1',
        ], 200),
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get(route('settings.history'))
        ->assertOk()
        ->assertViewIs('settings.history')
        ->assertViewHas('agentInfo');

    $agentInfo = $response->viewData('agentInfo');
    expect($agentInfo)->toHaveKeys(['device', 'browser', 'ip', 'real_ip']);
});

it('renders login history page gracefully when geo-location API returns failure status', function () {
    Http::fake([
        'http://ip-api.com/json/' => Http::response(['status' => 'fail'], 200),
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('settings.history'))
        ->assertOk()
        ->assertViewIs('settings.history');
});

it('renders login history page gracefully when geo-location API is unreachable', function () {
    Http::fake([
        'http://ip-api.com/json/' => function () {
            throw new \Illuminate\Http\Client\ConnectionException('Connection failed');
        },
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('settings.history'))
        ->assertOk()
        ->assertViewIs('settings.history');
});

// ============================================================
// DELETE ACCOUNT
// ============================================================

it('deletes the authenticated users account and redirects to landing page', function () {
    $user   = User::factory()->create();
    $userId = $user->id_user;

    $this->actingAs($user)
        ->delete(route('settings.deleteAccount'))
        ->assertRedirect(route('landing'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('user', ['id_user' => $userId]);
});

it('logs out the user after account deletion', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->delete(route('settings.deleteAccount'));

    $this->assertGuest();
});

it('does not delete another users record when one account is deleted', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $this->actingAs($userA)
        ->delete(route('settings.deleteAccount'));

    $this->assertDatabaseHas('user', ['id_user' => $userB->id_user]);
});
