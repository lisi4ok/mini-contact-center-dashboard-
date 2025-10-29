<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a user via factory', function () {
    $user = User::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.test',
        'password' => 'secret', // will be hashed by cast
    ]);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->exists)->toBeTrue()
        ->and($user->name)->toBe('Jane Doe')
        ->and($user->email)->toBe('jane@example.test')
        ->and($user->password)->not()->toBe('secret');
});

it('exposes the expected fillable attributes', function () {
    $user = new User();

    expect($user->getFillable())->toEqual([
        'name',
        'email',
        'password',
    ]);
});

it('hides the expected attributes', function () {
    $user = new User();

    expect($user->getHidden())->toEqual([
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ]);
});

it('defines the expected casts', function () {
    $user = new User();
    $casts = $user->getCasts();

    expect($casts)->toHaveKeys(['email_verified_at', 'password', 'two_factor_confirmed_at'])
        ->and($casts['email_verified_at'])->toBe('datetime')
        ->and($casts['password'])->toBe('hashed')
        ->and($casts['two_factor_confirmed_at'])->toBe('datetime');
});
