<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_user', function (Blueprint $table) {
            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('role');

            $table->string('status')
                ->default('active');

            $table->timestamp('joined_at')
                ->nullable();

            $table->timestamps();

            $table->primary([
                'tenant_id',
                'user_id',
            ]);

            $table->index([
                'user_id',
                'status',
            ]);

            $table->index([
                'tenant_id',
                'role',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_user');
    }
};
