<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\TenantInvitationController;
use App\Http\Middleware\EnsureTenantEmployeeHasActiveTenant;
use App\Http\Middleware\EnsureTenantOwnerHasActiveBilling;
use App\Http\Middleware\ResolveDefaultTenant;
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
            "tenant" => $context->tenant()?->toArray(),
            "tenant_id" => $context->tenantId(),
            "role" => $context->role(),
            "isSuperAdministrator" => $context->isSuperAdministrator(),
            "customer" => $context->tenant()?->asStripeCustomer()->toArray()

        ]);
    })->name('teste');

    Route::get("/invitation",[TenantInvitationController::class, 'index'])->name('tenant-invitation.index');
    Route::get('/invitation/{invitation}/accept/{token}', [TenantInvitationController::class, 'accept'])->name('tenant-invitation.accept');
    Route::post('/invitation/{invitation}/accept/{token}',[TenantInvitationController::class, 'confirm'])->middleware('auth')->name('tenant-invitation.confirm');
});


Route::middleware([
    'auth',
    ResolveDefaultTenant::class,
])->group(function () {
    Route::get('/teste-h', function () {
        $context = app(TenantContextService::class);

        $context->user();
        $context->tenant()->isSubscribed();
        $context->tenantId();
        $context->role();
        $context->isSuperAdministrator();

        dd([
            "user" => $context->user()->toArray(),
            "tenant" => $context->tenant()?->subscribed(),
            'subscription' =>  $context->tenant()?->subscriptions()->get()->toArray(),
            "tenant_id" => $context->tenantId(),
            "role" => $context->role(),
            "isSuperAdministrator" => $context->isSuperAdministrator(),
            "customer" => $context->tenant()?->asStripeCustomer()

        ]);
    })->name('teste-h');
});



Route::get("/new", function () {
   $tenant = App\Models\Tenant::findOrFail(4);

        $tenant->update([
            'billing_access_granted' => true,
            'billing_access_granted_until' => null,
        ]);
});


Route::get("/cliente", function () {
    return view('cliente');
});

Route::get("/cliente/new", function () {
    return view('customers.create');
});
