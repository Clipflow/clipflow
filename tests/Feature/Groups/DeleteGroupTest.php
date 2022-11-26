<?php

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Guests cannot delete a group', function () {
    $group = Group::factory()->create();

    $this->delete(route('groups.destroy', $group))
        ->assertRedirect(route('login'));

    $this->assertDatabaseCount('groups', 1);
});

test('Users cannot delete a group', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create();

    $this->actingAs($user)
        ->delete(route('groups.destroy', $group))
        ->assertForbidden();

    $this->assertDatabaseCount('groups', 1);
});

test('Group members cannot delete a group', function () {

    $group = Group::factory()->create();
    $user = User::factory()->create();
    $group->addMember($user);

    $this->actingAs($user)
        ->delete(route('groups.destroy', $group))
        ->assertForbidden();

    $this->assertDatabaseCount('groups', 1);
});

test('Group owners can delete a group', function () {
    $group = Group::factory()->create();
    $user = User::factory()->create();

    $group->addMember($user, GroupMember::ROLE_ADMIN);

    $this->actingAs($user)
        ->delete(route('groups.destroy', $group), [
            'name' => $group->name,
        ])
        ->assertRedirect(route('groups.index'));

    $this->assertDatabaseCount('groups', 0);
    $this->assertDatabaseCount('group_members', 0);
});

