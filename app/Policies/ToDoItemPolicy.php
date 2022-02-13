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
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ToDoItem  $todo
     * @return bool
     */
    public function update(User $user, ToDoItem $todo){
        return $user->id === $todo->user_id;
    }


}
