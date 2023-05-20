<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'descriptions' => $this->descriptions,
            'preview_image' => $this->preview_image,
            'creator_id' => $this->creator_id,
            'users' => $this->users
        ];
    }
}
