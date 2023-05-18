<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function update(User $user, Project $project)
    {
        // Разрешить обновление проекта только если пользователь связан с ним через pivot таблицу
        return $user->projects->contains($project);
    }

    public function delete(User $user, Project $project)
    {
        // Разрешить удаление проекта только если пользователь связан с ним через pivot таблицу
        return $user->projects->contains($project);
    }
}
