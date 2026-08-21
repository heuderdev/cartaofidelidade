<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('email', 255)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('cpf', 14)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('status', 30)->default('active');
            $table->string('external_reference', 150)->nullable();
            $table->jsonb('metadata')->default([]);
            $table->timestamp('last_visit_at')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'id']);
            $table->unique(['tenant_id', 'uuid']);
            $table->unique(['tenant_id', 'email']);
            $table->unique(['tenant_id', 'cpf']);
            $table->index(['tenant_id', 'phone']);
            $table->index(['tenant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
