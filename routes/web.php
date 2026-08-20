<?php

use App\Http\Controllers\BillingController;
use App\Http\Middleware\EnsureTenantEmployeeHasActiveTenant;
use App\Http\Middleware\EnsureTenantOwnerHasActiveBilling;
use App\Http\Middleware\InitializeTenantContext;
use App\Http\Middleware\ResolveDefaultTenant;
use App\Models\Exemplo;
use App\Services\Tenancy\TenantContextService;
use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__ . '/settings.php';

Route::get('/billing/success', fn() => view('billing.success'))->name('billing.success');
Route::get('/billing/cancel',  fn() => view('billing.cancel'))->name('billing.cancel');


Route::middleware('auth')->group(function () {
    Route::get('/checkout', [BillingController::class, 'checkout'])->name('checkout');
    Route::get('/portal', [BillingController::class, 'portal'])->name('portal');
    Route::get('/revalidate', [BillingController::class, 'revalidate'])->name('billing.revalidate');
});


Route::middleware([
    'auth',
    ResolveDefaultTenant::class,
    EnsureTenantOwnerHasActiveBilling::class,
    EnsureTenantEmployeeHasActiveTenant::class,
])->group(function () {
    Route::get('/teste', function () {
        $context = app(TenantContextService::class);

        $context->user();
        $context->tenant()->isSubscribed();
        $context->tenantId();
        $context->role();
        $context->isSuperAdministrator();

        dd([
            "user" => $context->user()->toArray(),
            "tenant" => $context->tenant()->isSubscribed(),
            "tenant_id" => $context->tenantId(),
            "role" => $context->role(),
            "isSuperAdministrator" => $context->isSuperAdministrator()

        ]);
    })->name('teste');

    Route::get('/heuder', function () {

        Exemplo::query()->get();



        Route::view('dashboard', 'dashboard')->name('dashboard2');
    });
});

Route::get("/new", function () {
   $tenant = App\Models\Tenant::findOrFail(4);

        $tenant->update([
            'billing_access_granted' => true,
            'billing_access_granted_until' => now()->setTime(23, 50),
        ]);
});
