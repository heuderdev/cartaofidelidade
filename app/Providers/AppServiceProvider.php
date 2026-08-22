<?php

namespace App\Providers;

use App\Models\Subscription;
use App\Models\Tenant;
use App\Services\Tenancy\TenantContextService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Cashier\Cashier;

use App\Http\Middleware\ResolveDefaultTenant;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(
            TenantContextService::class,
            static fn (): TenantContextService => new TenantContextService()
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update',$handle)->middleware([
                'web',
                'auth',
                ResolveDefaultTenant::class,
            ]);
        });

        Cashier::useCustomerModel(Tenant::class);
        Cashier::useSubscriptionModel(Subscription::class);

         DB::listen(function (QueryExecuted $query): void {
            Log::debug('SQL executado', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time_ms' => $query->time,
            ]);
        });

        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
