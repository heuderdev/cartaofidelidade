<?php

namespace App\Models\Concerns;

use App\Services\Tenancy\TenantContextService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(
            'tenant',
            function (Builder $builder): void {
                $context = app(
                    TenantContextService::class
                );

                if ($context->isSuperAdministrator()) {
                    return;
                }

                if (!$context->hasTenant()) {
                    throw new RuntimeException(
                        'Tenant não definido no contexto.'
                    );
                }

                $builder->where(
                    $builder->getModel()
                        ->qualifyColumn('tenant_id'),
                    $context->tenantId()
                );
            }
        );

        static::creating(function (Model $model): void {
            $context = app(
                TenantContextService::class
            );

            if ($context->isSuperAdministrator()) {
                throw new RuntimeException(
                    'Informe o tenant de destino.'
                );
            }

            $model->setAttribute(
                'tenant_id',
                $context->tenantId()
            );
        });

        static::updating(function (Model $model): void {
            $context = app(
                TenantContextService::class
            );

            if ($context->isSuperAdministrator()) {
                return;
            }

            if (
                (int) $model->tenant_id !==
                (int) $context->tenantId()
            ) {
                throw new RuntimeException(
                    'Registro pertence a outro tenant.'
                );
            }
        });
    }
}
