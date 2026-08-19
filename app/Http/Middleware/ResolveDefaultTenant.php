<?php

namespace App\Http\Middleware;

use App\Services\Tenancy\DefaultTenantResolver;
use App\Services\Tenancy\TenantContextService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveDefaultTenant
{
    public function __construct(
        private DefaultTenantResolver $resolver,
        private TenantContextService $context,
    ) {
    }

    public function handle(Request $request,Closure $next): Response {
        $user = $request->user();
        abort_unless($user, 401);

        [
            'tenant' => $tenant,
            'role' => $role,
        ] = $this->resolver->resolve($user);

        $this->context->set(
            user: $user,
            tenant: $tenant,
            role: $role
        );

        $request->attributes->set(
            'current_tenant',
            $tenant
        );

        $request->attributes->set(
            'current_role',
            $role
        );

        return $next($request);
    }
}
