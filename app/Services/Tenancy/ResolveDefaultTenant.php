<?php

namespace App\Services\Tenancy;

use App\Services\Tenancy\TenantContextService;
use App\Services\Tenancy\TenantResolver;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveDefaultTenant
{
    public function __construct(
        private readonly TenantResolver $resolver,
        private readonly TenantContextService $context,
    ) {
    }

    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        abort_unless(
            $user,
            401,
            'Usuário não autenticado.'
        );

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

        try {
            return $next($request);
        } finally {
            $this->context->clear();
        }
    }
}
