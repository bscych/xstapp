<?php

namespace App\Policies;

use App\User;
use App\Model\Spend;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpendPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the spend.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Spend  $spend
     * @return mixed
     */
    public function view(User $user)
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
     * Determine whether the user can create spends.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the spend.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Spend  $spend
     * @return mixed
     */
    public function update(User $user, Spend $spend)
    {
        //
    }

    /**
     * Determine whether the user can delete the spend.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Spend  $spend
     * @return mixed
     */
    public function delete(User $user, Spend $spend)
    {
        //
    }

    /**
     * Determine whether the user can restore the spend.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Spend  $spend
     * @return mixed
     */
    public function restore(User $user, Spend $spend)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the spend.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Spend  $spend
     * @return mixed
     */
    public function forceDelete(User $user, Spend $spend)
    {
        //
    }
}
