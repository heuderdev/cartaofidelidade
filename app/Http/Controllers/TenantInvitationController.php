<?php

namespace App\Http\Controllers;

use App\Models\TenantInvitation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TenantInvitationController extends Controller
{
    public function index(Request $request): View
    {
        return view('TenantInvitation.index');
    }

    public function accept(Request $request, TenantInvitation $invitation, string $token): View|RedirectResponse
    {
        $this->ensureValidToken(
            $invitation,
            $token
        );

        if (! $request->user()) {
            session([
                'url.intended' => $request->fullUrl(),
            ]);

            return redirect()
                ->route('login')
                ->with(
                    'warning',
                    'Faça login para aceitar o convite.'
                );
        }

        $this->ensureInvitationEmailMatchesUser($invitation, $request->user());

        return view('TenantInvitation.accept', [
            'invitation' => $invitation,
            'token' => $token,
        ]);
    }

    public function confirm(Request $request, TenantInvitation $invitation, string $token): RedirectResponse
    {
        $this->ensureValidToken($invitation, $token);

        /** @var User $user */
        $user = $request->user();

        $this->ensureInvitationEmailMatchesUser($invitation, $user);

        DB::transaction(function () use ($invitation, $user): void {
            /*
             * Garante que o usuário entra no tenant sem remover
             * os vínculos que ele possa ter em outros tenants.
             */
            $invitation->tenant->users()->syncWithoutDetaching([
                $user->getKey() => [
                    'role' => $invitation->role,
                    'status' => 'active',
                    'joined_at' => now(),
                ],
            ]);

            /*
             * Define o tenant aceito como padrão somente quando
             * o usuário ainda não tem tenant padrão.
             */

            $user->forceFill(['tenant_default_id' => $invitation->tenant_id])->save();

            $invitation->forceFill(['accepted_at' => now()])->save();
        });

        return redirect()
            ->route('dashboard')
            ->with('success', sprintf('Você entrou no tenant %s com sucesso.', $invitation->tenant->name));
    }

    private function ensureValidToken(TenantInvitation $invitation, string $token): void
    {
        abort_unless($invitation->isUsable(),  410,  'Este convite expirou, foi revogado ou já foi utilizado.');
        abort_unless(Hash::check($token, $invitation->token_hash), 403, 'Token de convite inválido.');
    }

    private function ensureInvitationEmailMatchesUser(TenantInvitation $invitation, User $user): void
    {
        abort_unless(strcasecmp($invitation->email, $user->email) === 0, 403, 'Faça login com o mesmo e-mail que recebeu o convite.');
    }
}
