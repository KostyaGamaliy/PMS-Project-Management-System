<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ChatPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewChat(User $user, Project $project) {
        return $user->projects->contains($project);
    }
}
