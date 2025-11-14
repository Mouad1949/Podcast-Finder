<?php

namespace App\Policies;

use App\Models\Episode;
use App\Models\Podcast;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EpisodePolicy
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
    public function view(User $user, Episode $episode): bool
    {
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role ,['animateur','admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Episode $episode): bool
    {
        return $user->role === 'admin' || ($user->role === 'aminateur' && $episode->podcast->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Episode $episode ,Podcast $podcast): bool
    {
        return $user->role === 'admin' || ($user->role === 'aminateur' && $episode->podcast->user_id === $user->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Episode $episode): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Episode $episode): bool
    {
        //
    }
}
