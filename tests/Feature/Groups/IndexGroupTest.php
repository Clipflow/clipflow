<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Guests cannot render the group index view', function () {

    $this->get(route('groups.index'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('Users can render the group index view', function () {

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('groups.index'))
        ->assertOk();

    $this->assertAuthenticated();
});
