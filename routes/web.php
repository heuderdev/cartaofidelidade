<?php

use App\Services\Tenancy\TenantContextService;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';


Route::middleware(['auth', 'tenant.default'])->group(function () {
    Route::get('/teste', function () {
        $context = app(TenantContextService::class);

        $context->user();
        $context->tenant();
        $context->tenantId();
        $context->role();
        $context->isSuperAdministrator();

        dd([
            "user" => $context->user()->toArray(),
            "tenant" => $context->tenant()->toArray(),
            "tenantId" =>$context->tenantId(),
            "role" => $context->role(),
            "isSuperAdministrator" =>$context->isSuperAdministrator()

        ]);
    })->name('teste');
});
