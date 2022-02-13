<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ToDoItem;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Session;

class ToDoItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given ToDoItem can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ToDoItem  $todo
     * @return bool
     */
    public function update(User $user, ToDoItem $todo){
        return $user->id === $todo->user_id;
    }

    /**
     * Determine if the given ToDoItem can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ToDoItem  $todo
     * @return bool
     */
    public function delete(User $user, ToDoItem $todo){
        return $user->id === $todo->user_id;
    }


}
