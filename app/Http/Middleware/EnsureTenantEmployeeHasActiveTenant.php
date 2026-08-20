<?php

namespace App\Http\Middleware;

use App\Services\Tenancy\TenantContextService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantEmployeeHasActiveTenant
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
         * Este middleware somente controla funcionários.
         * Owner e super administrador seguem sem bloqueio aqui.
         */
        if (! $this->context->hasRole('funcionario')) {
            return $next($request);
        }

        $tenant = $this->context->tenant();

        /*
         * Permite funcionário trabalhar quando o tenant está:
         * - Gratuito
         * - Em trial
         * - Assinatura ativa
         * - Liberado manualmente pelo administrador da plataforma
         */
        if ($tenant->hasBillingAccess()) {
            return $next($request);
        }

        return redirect()
            ->route('dashboard')
            ->with(
                'warning',
                'Esta empresa está sem acesso ativo. Contate o responsável pelo pagamento.'
            );
    }
}
