<?php

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Non members cannot view group members', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create();

    $response = $this->actingAs($user)->get(route('groups.members', $group));

    $response->assertForbidden();
});

test('Members can view group members', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create();
    $group->addMember($user);

    $response = $this->actingAs($user)->get(route('groups.members', $group));

    $response->assertOk();
});

test('Admins can view group members', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create();
    $group->addMember($user, GroupMember::ROLE_ADMIN);

    $response = $this->actingAs($user)->get(route('groups.members', $group));

    $response->assertOk();
});

test('Guests cannot view group members', function () {
    $group = Group::factory()->create();

    $response = $this->get(route('groups.members', $group));

    $response->assertRedirect(route('login'));
});
