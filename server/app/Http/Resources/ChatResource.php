<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'sender' => $this->sender->name,
            'receiver' => $this->receiver->name,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'project_id' => $this->project_id,
            'message' => $this->message,
            'created_at' => $this->created_at->format('d.m.Y'),
        ];
    }
}
