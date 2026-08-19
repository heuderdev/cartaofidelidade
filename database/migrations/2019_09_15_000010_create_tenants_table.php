<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')
                ->unique();

            $table->string('name');

            $table->string('slug')
                ->unique();

            $table->string('type')
                ->default('company')
                ->index();

            $table->string('status')
                ->default('active')
                ->index();

            $table->string('timezone')
                ->default('America/Sao_Paulo');

            $table->string('locale')
                ->default('pt_BR');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
