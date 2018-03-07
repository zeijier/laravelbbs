<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function update(User $currentUser,User $user){
//        echo $currentUser->id.'/'.$user->id;
//        die();
        return $currentUser->id === $user->id;
    }
}
