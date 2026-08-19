<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    use ProfileValidationRules;

    /**
     * @param array<string, mixed> $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($input): User {
            $tenant = Tenant::create([
                'uuid' => (string) Str::uuid(),
                'name' => $input['name'],
                'slug' => sprintf(
                    '%s-%s',
                    Str::slug($input['name']),
                    Str::lower(Str::random(6))
                ),
                'type' => 'company',
                'status' => 'active',
                'timezone' => 'America/Sao_Paulo',
                'locale' => 'pt_BR',
            ]);

            $user = User::create([
                'name' => $input['name'],
                'email' => strtolower($input['email']),
                'password' => Hash::make($input['password']),
                'tenant_default_id' => $tenant->id,
            ]);

            $tenant->users()->attach($user->id, [
                'role' => 'owner',
                'status' => 'active',
                'joined_at' => now(),
            ]);

            return $user;
        });
    }
}
