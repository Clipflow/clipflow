<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Group extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    public function scopeAdmins($query)
    {
        return $query->whereHas('members', function ($query) {
            $query->where('role', GroupMember::ROLE_ADMIN);
        });
    }

    public function scopeMembers($query)
    {
        return $query->whereHas('members', function ($query) {
            $query->where('role', GroupMember::ROLE_MEMBER);
        });
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members')
            ->using(GroupMember::class)
            ->withTimestamps()
            ->withPivot('role');
    }

    public function admins()
    {
        return $this->members()->wherePivot('role', GroupMember::ROLE_ADMIN);
    }

    public function addMember(User $user, string $role = GroupMember::ROLE_MEMBER)
    {
        $this->members()->attach($user, ['role' => $role]);
    }

    public function removeMember(User $user)
    {
        $this->members()->detach($user);
    }

    public function isMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    public function isAdmin(User $user): bool
    {
        return $this->admins()->where('user_id', $user->id)->exists();
    }

    public function processImage(UploadedFile $file): void
    {
        $fileName = $this->getKey().'.'.$file->getClientOriginalExtension();

        $image = Image::make($file)->fit(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        });

        Storage::put('public/groups/'.$fileName, (string) $image->encode());

        $this->forceFill(['image_url' => 'groups/'.$fileName])->save();
    }

    public function removeImage(): void
    {
        Storage::delete('public/'.$this->image_url);

        $this->forceFill(['image_url' => null])->save();
    }

    public function hasImage(): bool
    {
        return $this->image_url !== null;
    }

    public static function boot(): void
    {
        parent::boot();

        static::deleting(static function ($group) {
            $group->members()->detach();
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
