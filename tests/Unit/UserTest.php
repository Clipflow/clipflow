<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('user has gravatar', function () {

    $user = User::factory()->create();

    expect($user->avatar)->toContain('gravatar.com');
});
