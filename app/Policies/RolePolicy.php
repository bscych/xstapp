<?php

namespace App\Policies;

use App\User;
use App\Model\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\User  $user
     * @param  \App\=Model\Role  $role
     * @return mixed
     */
    public function view(User $user)
    {
        if($user->id===1){
           return true;
       }
       if($user->id===2){
           return true;
       }
       else{
           return false;
       }
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->id===1){
           return true;
       }
       if($user->id===2){
           return true;
       }else{
           return false;
       }
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\User  $user
     * @param  \App\=Model\Role  $role
     * @return mixed
     */
    public function update(User $user)
    {
        if($user->id===1){
           return true;
       }
       if($user->id===2){
           return true;
       }else{
           return false;
       }
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\User  $user
     * @param  \App\=Model\Role  $role
     * @return mixed
     */
    public function delete(User $user)
    {
         if($user->id===1){
           return true;
       }
       if($user->id===2){
           return true;
       }else{
           return false;
       }
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \App\User  $user
     * @param  \App\=Model\Role  $role
     * @return mixed
     */
    public function restore(User $user)
    {
       if($user->id===1){
           return true;
       }
       if($user->id===2){
           return true;
       }else{
           return false;
       }
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  \App\User  $user
     * @param  \App\=Model\Role  $role
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        if($user->id===1){
           return true;
       }
       if($user->id===2){
           return true;
       }else{
           return false;
       }
    }
}
