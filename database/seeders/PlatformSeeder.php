<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $platform = Tenant::query()->firstOrCreate(
                ['type' => 'platform'],
                [
                    'name' => 'Plataforma',
                    'slug' => 'platform',
                    'status' => 'active',
                    'is_free' => true,
                ]
            );

            $user = User::query()->firstOrCreate(
                ['email' => 'heuderdev@gmail.com'],
                [
                    'name' => 'Administrador da Plataforma',
                    'password' => Hash::make('password'),
                    'tenant_default_id' => $platform->getKey(),
                ]
            );

            $user->tenants()->syncWithoutDetaching([
                $platform->getKey() => [
                    'role' => 'super_administrador',
                    'status' => 'active',
                    'joined_at' => now(),
                ],
            ]);

            $user->forceFill([
                'tenant_default_id' => $platform->getKey(),
            ])->saveQuietly();

            if (! $platform->hasStripeId()) {
                $platform->createAsStripeCustomer([
                    'name' => $platform->name,
                    'email' => $user->email,
                    'metadata' => [
                        'tenant_id' => (string) $platform->getKey(),
                        'tenant_type' => $platform->type,
                    ],
                ]);
            }
        });
    }
}
