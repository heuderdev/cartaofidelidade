<?php

namespace App\Services\Tenancy;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class TenantResolver
{
    /**
     * @return array{
     *     tenant: Tenant,
     *     role: string
     * }
     */
    public function resolve(User $user): array
    {
        $tenant = $user->tenants()
            ->whereKey($user->tenant_default_id)
            ->wherePivot('status', 'active')
            ->first();

        if (! $tenant instanceof Tenant) {
            throw ValidationException::withMessages([
                'tenant' => 'Tenant padrão não encontrado ou inativo.',
            ]);
        }

        return [
            'tenant' => $tenant,
            'role' => (string) $tenant->pivot->role,
        ];
    }
}
