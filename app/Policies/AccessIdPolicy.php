<?php

namespace App\Policies;

use App\Models\AccessId;
use App\Models\User;
use App\Policies\Traits\AuthorizesTenancy;

class AccessIdPolicy
{
    use AuthorizesTenancy;

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, AccessId $accessId): bool {
        return $this->isSuper($user) || $accessId->account_id === $user->account_id;
    }
    public function create(User $user): bool {
        return $this->isSuper($user) || $user->hasRole('community_admin');
    }
    public function update(User $user, AccessId $accessId): bool {
        return $this->isSuper($user) || $accessId->account_id === $user->account_id;
    }
    public function delete(User $user, AccessId $accessId): bool {
        return $this->isSuper($user) || $accessId->account_id === $user->account_id;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AccessId $accessId): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AccessId $accessId): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AccessId $accessId): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AccessId $accessId): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AccessId $accessId): bool
    {
        return false;
    }
}
