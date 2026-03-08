<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;

class TenantPolicy
{
    public function view(User $user, Tenant $tenant): bool
    {
        return $tenant->user_id === $user->id || $tenant->account_id === $user->id;
    }

    public function update(User $user, Tenant $tenant): bool
    {
        return $tenant->user_id === $user->id;
    }

    public function delete(User $user, Tenant $tenant): bool
    {
        return $tenant->user_id === $user->id;
    }
}
