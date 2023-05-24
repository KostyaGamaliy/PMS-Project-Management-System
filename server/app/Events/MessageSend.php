<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSend implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $sender;
    public $sender_id;
    public $project_id;
    public $created_at;
    public $id;
    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->id = $message->id;
        $this->message = $message->message;
        $this->sender = $message->sender->name;
        $this->project_id = $message->project_id;
        $this->sender_id = $message->sender_id;
        $this->created_at = $message->created_at->format('d.m.Y');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('chat.'.$this->project_id);
    }

    public function broadcastAs(): string
    {
        return 'new-message';
    }
}
