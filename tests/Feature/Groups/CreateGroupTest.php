<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Guests cannot render the group create view', function () {
    $this->get(route('groups.create'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('Users can render the group create view', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('groups.create'))
        ->assertOk();

    $this->assertAuthenticated();
});

test('Guests cannot create a group', function () {
    $this->post(route('groups.store'), [
        'name' => 'Test Group',
    ])
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('Users can create a group', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('groups.store'), [
            'name' => 'Test Group',
        ])
        ->assertRedirect(route('groups.show', Group::first()));

    $this->assertAuthenticated();
});

test('Validation rules are required', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('groups.store'), [
            'name' => '',
        ])
        ->assertSessionHasErrors('name');

    $this->assertAuthenticated();
});

test('Image must be an image', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('groups.store'), [
            'name' => 'Test Group',
            'image_url' => 'not-an-image',
        ])
        ->assertSessionHasErrors('image_url');

    $this->assertAuthenticated();
});
