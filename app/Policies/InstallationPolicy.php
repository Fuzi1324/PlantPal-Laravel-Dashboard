<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Installation;
use App\Models\User;

class InstallationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Installation $installation)
    {
        return $user->id === $installation->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Installation $installation)
    {
        return $user->id === $installation->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Installation $installation): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Installation $installation): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Installation $installation): bool
    {
        //
    }
}
