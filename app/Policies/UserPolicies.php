<?php

namespace App\Policies;

use App\User;


class PostPolicy
{
    public function update(User $user,$userToEdit) {
return true;
        return $user->user_id === $userToEdit;
    }

}
