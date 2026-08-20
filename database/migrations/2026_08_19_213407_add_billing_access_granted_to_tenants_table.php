<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table): void {
            $table->boolean('billing_access_granted')
                ->default(false)
                ->after('status');

            $table->timestamp('billing_access_granted_until')
                ->nullable()
                ->after('billing_access_granted');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table): void {
            $table->dropColumn([
                'billing_access_granted',
                'billing_access_granted_until',
            ]);
        });
    }
};
