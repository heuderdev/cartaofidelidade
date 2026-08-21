<?php

namespace App\Services\TenantInvitation;

use App\Models\Tenant;
use App\Models\TenantInvitation;
use App\Models\User;
use App\Notifications\TenantInvitationNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateService
{
    /**
     * Cria um convite para um usuário entrar em um tenant.
     *
     * @param array{
     *     tenant_id: int,
     *     invited_by: int,
     *     email: string,
     *     role?: string
     * } $data
     *
     * @return array{
     *     invitation: TenantInvitation,
     *     token: string
     * }
     */
    public function handle(array $data): array
    {
        $tenant = Tenant::query()
            ->findOrFail($data['tenant_id']);

        $inviter = User::query()
            ->findOrFail($data['invited_by']);

        $email = Str::lower(
            Str::squish($data['email'])
        );

        $role = $data['role'] ?? 'employee';

        $this->ensureInviterCanInvite(
            $tenant,
            $inviter
        );

        $this->ensureEmailIsNotMember(
            $tenant,
            $email
        );

        $this->revokeExistingInvitations(
            $tenant,
            $email
        );

        $plainToken = Str::random(64);

        $invitation = DB::transaction(
            function () use (
                $tenant,
                $inviter,
                $email,
                $role,
                $plainToken
            ): TenantInvitation {
                return TenantInvitation::query()->create([
                    'tenant_id' => $tenant->getKey(),
                    'invited_by' => $inviter->getKey(),
                    'email' => $email,
                    'role' => $role,
                    'token_hash' => Hash::make($plainToken),
                    'expires_at' => now()->addDays(7),
                ]);
            }
        );

        Notification::route('mail', $invitation->email)
        ->notify(
            new TenantInvitationNotification(
                $invitation,
                $plainToken
            )
        );

        return [
            'invitation' => $invitation,
            'token' => $plainToken,
        ];
    }

    private function ensureInviterCanInvite(
        Tenant $tenant,
        User $inviter
    ): void {
        $canInvite = $tenant->users()
            ->whereKey($inviter->getKey())
            ->wherePivot('status', 'active')
            ->wherePivotIn('role', [
                'owner',
                'super_administrador',
            ])
            ->exists();

        if (! $canInvite) {
            throw ValidationException::withMessages([
                'inviter' => 'Usuário não pode criar convites para este tenant.',
            ]);
        }
    }

    private function ensureEmailIsNotMember(
        Tenant $tenant,
        string $email
    ): void {
        $alreadyMember = $tenant->users()
            ->whereRaw('LOWER(users.email) = ?', [$email])
            ->exists();

        if ($alreadyMember) {
            throw ValidationException::withMessages([
                'email' => 'Este e-mail já pertence a empresa.',
            ]);
        }
    }

    private function revokeExistingInvitations(
        Tenant $tenant,
        string $email
    ): void {
        TenantInvitation::query()
            ->where('tenant_id', $tenant->getKey())
            ->whereRaw('LOWER(email) = ?', [$email])
            ->whereNull('accepted_at')
            ->whereNull('revoked_at')
            ->update([
                'revoked_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
