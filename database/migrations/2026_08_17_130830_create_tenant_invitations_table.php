<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_invitations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();

            $table->foreignId('invited_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('email');

            $table->string('role')
                ->default('member');

            $table->string('token_hash')
                ->unique();

            $table->timestamp('expires_at');

            $table->timestamp('accepted_at')
                ->nullable();

            $table->timestamp('revoked_at')
                ->nullable();

            $table->timestamps();

            $table->index([
                'tenant_id',
                'email',
            ]);

            $table->index([
                'tenant_id',
                'expires_at',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'tenant_invitations'
        );
    }
};
