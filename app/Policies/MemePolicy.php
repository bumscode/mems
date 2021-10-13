<?php

namespace App\Policies;

use App\Models\Meme;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MemePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        // only true if part of team
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Meme $meme
     * @return Response|bool
     */
    public function view(User $user, Meme $meme)
    {
        // only true if part of team
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        // only true if part of team
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Meme $meme
     * @return Response|bool
     */
    public function update(User $user, Meme $meme)
    {
        return $user->id === $meme->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Meme $meme
     * @return Response|bool
     */
    public function delete(User $user, Meme $meme)
    {
        return $user->id === $meme->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Meme $meme
     * @return Response|bool
     */
    public function restore(User $user, Meme $meme)
    {
        // return $user->teamRole() === TeamRoles::ADMIN
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Meme $meme
     * @return Response|bool
     */
    public function forceDelete(User $user, Meme $meme)
    {
        //
    }
}
