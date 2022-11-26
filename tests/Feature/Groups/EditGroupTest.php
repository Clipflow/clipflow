<?php

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot render edit page', function () {
    $group = Group::factory()->create();

    $response = $this->get(route('groups.edit', $group));

    $response->assertRedirect(route('login'));
});

test('users cannot render edit page', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create();

    $response = $this->actingAs($user)->get(route('groups.edit', $group));

    $response->assertForbidden();
});

test('group members cant render edit page', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create();

    $group->addMember($user);

    $response = $this->actingAs($user)->get(route('groups.edit', $group));

    $response->assertForbidden();
});

test('group admins can render edit page', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create();

    $group->addMember($user, GroupMember::ROLE_ADMIN);

    $response = $this->actingAs($user)->get(route('groups.edit', $group));

    $response->assertOk();
});

test('Guests cannot update group', function () {

    $group = Group::factory()->create();

    $response = $this->put(route('groups.update', $group), [
        'name' => 'New Name',
        'description' => 'New Description',
    ]);

    $response->assertRedirect(route('login'));

    $this->assertDatabaseMissing('groups', [
        'name' => 'New Name',
        'description' => 'New Description',
    ]);
});

test('users cannot update group', function () {

    $user = User::factory()->create();
    $group = Group::factory()->create();

    $response = $this->actingAs($user)->put(route('groups.update', $group), [
        'name' => 'New Name',
        'description' => 'New Description',
    ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('groups', [
        'name' => 'New Name',
        'description' => 'New Description',
    ]);
});

test('group members cannot update group', function () {

    $user = User::factory()->create();
    $group = Group::factory()->create();

    $group->addMember($user);

    $response = $this->actingAs($user)->put(route('groups.update', $group), [
        'name' => 'New Name',
        'description' => 'New Description',
    ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('groups', [
        'name' => 'New Name',
        'description' => 'New Description',
    ]);
});

test('group admins can update group', function () {

    $user = User::factory()->create();
    $group = Group::factory()->create();

    $group->addMember($user, GroupMember::ROLE_ADMIN);

    $response = $this->actingAs($user)->put(route('groups.update', $group), [
        'name' => 'New Name',
        'description' => 'New Description',
    ]);

    $response->assertStatus(302);

    $this->assertDatabaseHas('groups', [
        'name' => 'New Name',
        'description' => 'New Description',
    ]);
});

test('Validation rules are required', function () {

    $user = User::factory()->create();
    $group = Group::factory()->create();

    $group->addMember($user, GroupMember::ROLE_ADMIN);

    $response = $this->actingAs($user)->put(route('groups.update', $group), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors(['name']);
});
