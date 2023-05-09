<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'user_id' => $this->user_id,
            'assigner_id' => $this->assigner_id,
            'dashboard_id' => $this->dashboard_id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'user' => $this->user,
        ];
    }
}
