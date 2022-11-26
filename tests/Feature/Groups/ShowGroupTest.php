<?php

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Non members cannot view a group', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create();

    $response = $this->actingAs($user)->get(route('groups.show', $group));

    $response->assertForbidden();
});

test('Members can view a group', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create();
    $group->addMember($user);

    $response = $this->actingAs($user)->get(route('groups.show', $group));

    $response->assertOk();
});

test('Admins can view a group', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create();
    $group->addMember($user, GroupMember::ROLE_ADMIN);

    $response = $this->actingAs($user)->get(route('groups.show', $group));

    $response->assertOk();
});

test('Guests cannot view a group', function () {

    $group = Group::factory()->create();

    $response = $this->get(route('groups.show', $group));

    $response->assertRedirect(route('login'));
});
