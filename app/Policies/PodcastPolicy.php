<?php

namespace App\Policies;

use App\Models\Podcast;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PodcastPolicy
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
    public function view(User $user, Podcast $podcast): bool
    {
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // return $user->role === 'animateur' || $user->role === 'admin';
        return in_array($user->role,['admin', 'animateur']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Podcast $podcast): bool
    {
        return ($user->role === 'animateur' && $user->id === $podcast->user_id) || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Podcast $podcast): bool
    {
        return $user->role === 'admin' || ($user->role === 'animateur' && $user->id === $podcast->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Podcast $podcast): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Podcast $podcast): bool
    {
        //
    }
}
