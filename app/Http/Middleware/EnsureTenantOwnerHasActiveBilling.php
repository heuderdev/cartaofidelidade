<?php

namespace App\Http\Middleware;

use App\Services\Tenancy\TenantContextService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantOwnerHasActiveBilling
{
    public function __construct(
        private readonly TenantContextService $context,
    ) {
    }

    public function handle(
        Request $request,
        Closure $next
    ): Response {
        /*
         * Usuários que não são owners não são bloqueados aqui.
         * O middleware de funcionário decide o acesso deles.
         */
        if (! $this->context->hasRole('owner')) {
            return $next($request);
        }

        $tenant = $this->context->tenant();

        /*
         * Empresa já tem acesso:
         * - Plano gratuito
         * - Trial
         * - Assinatura Stripe válida
         * - Liberação manual no tenant
         */
        if ($tenant->hasBillingAccess()) {
            return $next($request);
        }

        /*
         * Mesmo inadimplente, o owner precisa poder:
         * - Ir para checkout
         * - Abrir portal Stripe
         * - Voltar das URLs Stripe
         * - Revalidar a assinatura
         */
        if ($request->routeIs(
            'checkout',
            'portal',
            'billing.success',
            'billing.cancel',
            'billing.revalidate'
        )) {
            return $next($request);
        }

        return redirect()
            ->route('checkout')
            ->with(
                'warning',
                'Regularize a assinatura para continuar usando a plataforma.'
            );
    }
}
