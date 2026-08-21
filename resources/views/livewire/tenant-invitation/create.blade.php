<div>
    @if (session()->has('success'))
        <div
            class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"
            role="alert"
        >
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        <div>
            <label
                for="email"
                class="mb-2 block text-sm font-medium text-gray-700"
            >
                E-mail do funcionário
            </label>

            <input
                id="email"
                type="email"
                wire:model.blur="email"
                autocomplete="email"
                placeholder="funcionario@empresa.com"
                class="block w-full rounded-lg border px-3 py-2 text-sm outline-none transition
                    @error('email')
                        border-red-500 focus:border-red-500 focus:ring-2 focus:ring-red-200
                    @else
                        border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                    @enderror"
            >

            @error('email')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label
                for="role"
                class="mb-2 block text-sm font-medium text-gray-700"
            >
                Função no tenant
            </label>

            <select
                id="role"
                wire:model="role"
                class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
            >
                <option value="owner">
                    Proprietário
                </option>

                 <option value="administrador">
                    Administrador
                </option>

                <option value="employee">
                Funcionário
                </option>

                <option value="cliente">
                    Cliente
                </option>
            </select>

            @error('role')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="save"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="save">
                    Enviar convite
                </span>

                <span wire:loading wire:target="save">
                    Criando convite...
                </span>
            </button>
        </div>
    </form>
</div>

