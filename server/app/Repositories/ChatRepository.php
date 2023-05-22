<?php

    namespace App\Repositories;

    use App\Models\Message;
    use App\Repositories\Interfaces\ChatRepositoryInterface;
    use Illuminate\Support\Facades\Auth;

    class ChatRepository implements ChatRepositoryInterface
    {
        public function list($user_id, $project_id)
        {
            return Message::where(function($query) use($project_id)  {
                $query->where('project_id', '=', $project_id);
            })->orderBy('created_at', 'ASC')->get();
        }

        public function send($data) {
            $message = new Message;
            $message->fill($data)->save();
            return $message;
        }
    }
