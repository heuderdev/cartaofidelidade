<?php

namespace App\Services\Tenancy;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class DefaultTenantResolver
{
    public function resolve(User $user): array
    {
        if (!$user->tenant_default_id) {
            throw new AuthorizationException(
                'O usuário não possui tenant_default_id.'
            );
        }

        $tenant = $user->tenants()
            ->whereKey($user->tenant_default_id)
            ->wherePivot('status', 'active')
            ->first();

        if (!$tenant) {
            throw new AuthorizationException(
                'O tenant padrão não pertence ao usuário.'
            );
        }

        if ($tenant->status !== 'active') {
            throw new AuthorizationException(
                'O tenant padrão está inativo.'
            );
        }

        return [
            'tenant' => $tenant,
            'role' => (string) $tenant->pivot->role,
        ];
    }
}
