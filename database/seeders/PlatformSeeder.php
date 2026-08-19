<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $platform = Tenant::query()->firstOrCreate(
            [
                'type' => 'platform',
            ],
            [
                'name' => 'Plataforma',
                'slug' => 'platform',
                'status' => 'active',
            ]
        );

        $user = User::query()->firstOrCreate(
            [
                'email' => 'heuderdev@gmail.com',
            ],
            [
                'name' => 'Administrador da Plataforma',
                'password' => Hash::make('password'),
                'tenant_default_id' => $platform->id,
            ]
        );

        $user->tenants()->syncWithoutDetaching([
            $platform->id => [
                'role' => 'super_administrador',
                'status' => 'active',
                'joined_at' => now(),
            ],
        ]);

        $user->forceFill([
            'tenant_default_id' => $platform->id,
        ])->saveQuietly();
    }
}
