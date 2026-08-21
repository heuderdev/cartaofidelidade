<?php

namespace App\Livewire\TenantInvitation;

use App\Services\Tenancy\TenantContextService;
use App\Services\TenantInvitation\CreateService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.default')]
class Create extends Component
{
    public string $email = '';

    public string $role = 'employee';

    protected function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'role' => [
                'required',
                'string',
               'in:owner,administrador,employee,cliente',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'role.in' => 'Selecione uma função válida.',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'email' => 'e-mail',
            'role' => 'função',
        ];
    }

    public function save(
        CreateService $createInvitation,
        TenantContextService $tenantContext
    ): void {
        $validated = $this->validate();

        $createInvitation->handle([
            'tenant_id' => $tenantContext->tenantId(),
            'invited_by' => $tenantContext->user()->getKey(),
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        $this->reset('email');
        $this->resetValidation();

        session()->flash(
            'success',
            'Convite criado com sucesso.'
        );
    }

    public function render()
    {
        return view('livewire.tenant-invitation.create');
    }
}
