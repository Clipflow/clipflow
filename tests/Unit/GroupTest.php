<?php

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('admins scope returns admins', function () {

    $group = Group::factory()->create();

    $group->addMember($user = User::factory()->create(), GroupMember::ROLE_ADMIN);

    $this->assertTrue($group->admins()->exists());

    $this->assertTrue($group->admins()->first()->is($user));
});

test('user scope returns only users', function () {

    $group = Group::factory()->create();

    $group->addMember($user = User::factory()->create(), GroupMember::ROLE_MEMBER);

    $this->assertTrue($group->members()->exists());

    $this->assertTrue($group->members()->first()->is($user));
});

test('addMember adds a member to the group', function () {

    $group = Group::factory()->create();

    $group->addMember($user = User::factory()->create());

    $this->assertTrue($group->isMember($user));
});

test('removeMember removes a member from the group', function () {

    $group = Group::factory()->create();

    $group->addMember($user = User::factory()->create());

    $group->removeMember($user);

    $this->assertFalse($group->isMember($user));
});

test('returns true if the user is a member of the group', function () {

    $group = Group::factory()->create();

    $group->addMember($user = User::factory()->create());

    $this->assertTrue($group->isMember($user));
});

test('returns false if the user is not a member of the group', function () {

    $group = Group::factory()->create();

    $this->assertFalse($group->isMember(User::factory()->create()));
});

test('returns true if the user is an admin of the group', function () {

    $group = Group::factory()->create();

    $group->addMember($user = User::factory()->create(), GroupMember::ROLE_ADMIN);

    $this->assertTrue($group->isAdmin($user));
});

test('returns false if the user is not an admin of the group', function () {

    $group = Group::factory()->create();

    $this->assertFalse($group->isAdmin(User::factory()->create()));
});

test('returns true if an image is set', function () {

    $group = Group::factory()->create();

    $group->processImage(UploadedFile::fake()->image('avatar.jpg'));

    $this->assertTrue($group->hasImage());
});

test('returns false if an image is not set', function () {

    $group = Group::factory()->create(['image_url' => null]);

    $this->assertFalse($group->hasImage());
});

test('an image can be uploaded to the group', function () {

    $group = Group::factory()->create(['image_url' => null]);

    $group->processImage(UploadedFile::fake()->image('avatar.jpg'));

    $this->assertNotNull($group->image_url);
    $this->assertFileExists(storage_path('app/public/'.$group->image_url));
});

test('an image can be removed from the group', function () {

    $group = Group::factory()->create();

    $group->processImage(UploadedFile::fake()->image('avatar.jpg'));

    $this->assertTrue($group->hasImage());
    $this->assertFileExists(storage_path('app/public/'.$group->image_url));

    $group->removeImage();

    $this->assertNull($group->image_url);
});
