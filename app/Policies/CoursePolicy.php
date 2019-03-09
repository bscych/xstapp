<?php

namespace App\Policies;

use App\User;
use App\Model\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the course.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Course  $course
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
        if($user->id===3){
           return true;
       } if($user->id===12){
           return true;
       }
       else{
           return false;
       }
    }

    /**
     * Determine whether the user can create courses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the course.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Course  $course
     * @return mixed
     */
    public function update(User $user, Course $course)
    {
        //
    }

    /**
     * Determine whether the user can delete the course.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Course  $course
     * @return mixed
     */
    public function delete(User $user, Course $course)
    {
        //
    }

    /**
     * Determine whether the user can restore the course.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Course  $course
     * @return mixed
     */
    public function restore(User $user, Course $course)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the course.
     *
     * @param  \App\User  $user
     * @param  \App\Model\Course  $course
     * @return mixed
     */
    public function forceDelete(User $user, Course $course)
    {
        //
    }
}
