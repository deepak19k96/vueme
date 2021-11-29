<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'slug'=> $this->slug,
            'path' => $this->path,
            'psychics' => $this->users()->count(),
            'image' => $this->image,
            'path' => $this->path,
            'url' => route('specialty', $this->slug),
            'color' => $this->color,
            'users_count' => $this->users()->count(),
            'online' => $this->users()->where('online', true)->count(),
        ];
    }
}
