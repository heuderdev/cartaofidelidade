<?php

namespace App\Http\Middleware;

use App\Services\Tenancy\TenantContextService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenantContext
{
    public function handle(Request $request,Closure $next): Response {
        $user = $request->user();

        abort_unless($user, 401, 'Usuário não autenticado.');

        $tenant = $user->tenants()
            ->whereKey($user->tenant_default_id)
            ->wherePivot('status', 'active')
            ->first();

        abort_unless($tenant, 403, 'Tenant não definido.');

        $role = $tenant->pivot->role;

        app(TenantContextService::class)->set(
            $user,
            $tenant,
            $role
        );

        try {
            return $next($request);
        } finally {
            app(TenantContextService::class)->clear();
        }
    }
}
