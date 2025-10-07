<?php
namespace App\Policies\Traits;

use App\Models\User;

trait AuthorizesTenancy
{
    protected function isSuper(User $user): bool {
        return $user->hasRole('superuser');
    }
}
