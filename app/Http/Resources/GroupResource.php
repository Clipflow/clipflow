<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GroupResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $relation = $this->loadMissing('creator');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image_url' => $this->hasImage() ? Storage::url($this->image_url) : null,
            'description' => $this->description,
            'creator_details' => [
                'name' => $relation->creator->name,
                'avatar_url' => $relation->creator->avatar,
            ],
            'members_count' => $this->numberOfMembers(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
