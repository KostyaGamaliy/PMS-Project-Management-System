<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSend;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\ChatResource;
use App\Repositories\Interfaces\ChatRepositoryInterface;

class ChatController extends Controller
{
    /**
     * @var repository
     */
    private $repository;

    /**
     * UserController constructor.
     *
     * @param repository $repository
     */
    public function __construct(ChatRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($project_id, $user_id)
    {
        $messages = $this->repository->list($user_id, $project_id);
        return ChatResource::collection($messages);
    }

    public function send(MessageRequest $request)
    {
        $message = $this->repository->send($request->validated());
        //репозиторій виклик, який повертає модель повідомлення
        broadcast(new MessageSend($message));
        // повертаю ресурс
        return new ChatResource($message);
    }
}
