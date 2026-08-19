<?php

namespace App\Services\Tenancy;

use App\Models\Tenant;
use App\Models\User;
use RuntimeException;

class TenantContextService
{
    private ?User $user = null;

    private ?Tenant $tenant = null;

    private ?string $role = null;

    public function set(
        User $user,
        Tenant $tenant,
        string $role
    ): void {
        $this->user = $user;
        $this->tenant = $tenant;
        $this->role = $role;
    }

    public function clear(): void
    {
        $this->user = null;
        $this->tenant = null;
        $this->role = null;
    }

    public function user(): User
    {
        return $this->user
            ?? throw new RuntimeException(
                'Usuário não definido.'
            );
    }

    public function tenant(): Tenant
    {
        return $this->tenant
            ?? throw new RuntimeException(
                'Tenant não definido.'
            );
    }

    public function tenantId(): int
    {
        return $this->tenant()->id;
    }

    public function role(): string
    {
        return $this->role
            ?? throw new RuntimeException(
                'Role não definido.'
            );
    }

    public function hasTenant(): bool
    {
        return $this->tenant !== null;
    }

    public function isSuperAdministrator(): bool
    {
        return $this->tenant()->isPlatform()
            && $this->role() === 'super_administrador';
    }

    public function isGlobal(): bool
    {
        return $this->isSuperAdministrator();
    }

    public function hasRole(
        string|array $roles
    ): bool {
        return in_array(
            $this->role(),
            (array) $roles,
            true
        );
    }
}
