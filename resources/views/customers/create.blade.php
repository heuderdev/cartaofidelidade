@extends('layouts.barber')

@section('title', 'Novo cliente')
@section('page-title', 'Novo cliente')
@section('breadcrumb', 'Clientes / Novo cadastro')

@section('content')
    <div class="mx-auto w-full max-w-6xl">
        {{-- Cabeçalho --}}
        <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm text-gray-500">
                    Cadastre um cliente para criar o cartão de fidelidade.
                </p>

                <p class="mt-1 text-xs text-gray-400">
                    Os campos marcados com * são obrigatórios.
                </p>
            </div>

            <button
                type="button"
                onclick="history.back()"
                class="
                    inline-flex items-center justify-center gap-2
                    rounded-xl border border-gray-200 bg-white
                    px-4 py-3 text-sm font-semibold text-gray-700
                    shadow-sm transition hover:bg-gray-50
                "
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                    />
                </svg>

                Voltar
            </button>
        </div>

        {{-- Card do formulário --}}
        <div class="barber-card overflow-hidden">
            {{-- Cabeçalho interno --}}
            <div class="border-b border-gray-100 px-6 py-5 sm:px-8">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#f7efe4] text-[#a4773e]">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                            />
                        </svg>
                    </div>

                    <div>
                        <h2 class="barber-title text-xl">
                            Dados do cliente
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Informe os dados básicos para criar o cartão.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Formulário --}}
            <form
                method="POST"
                action="#"
                class="px-6 py-6 sm:px-8 sm:py-8"
            >
                @csrf

                <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">
                    {{-- Nome --}}
                    <div class="md:col-span-2">
                        <label
                            for="name"
                            class="mb-2 block text-sm font-semibold text-gray-800"
                        >
                            Nome completo
                            <span class="text-[#b4773e]">*</span>
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            placeholder="Ex.: Carlos Henrique"
                            autocomplete="name"
                            required
                            autofocus
                            class="
                                block min-h-12 w-full rounded-xl border border-gray-200
                                bg-white px-4 py-3 text-base text-gray-900
                                placeholder:text-gray-400
                                outline-none transition
                                focus:border-[#c99b5b]
                                focus:ring-4 focus:ring-[#c99b5b]/10
                            "
                        >

                        <p class="mt-1.5 text-xs text-gray-500">
                            Informe o nome que será exibido no cartão.
                        </p>

                        @error('name')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label
                            for="phone"
                            class="mb-2 block text-sm font-semibold text-gray-800"
                        >
                            WhatsApp
                            <span class="text-[#b4773e]">*</span>
                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            value="{{ old('phone') }}"
                            placeholder="(61) 99999-9999"
                            autocomplete="tel"
                            inputmode="tel"
                            required
                            class="
                                block min-h-12 w-full rounded-xl border border-gray-200
                                bg-white px-4 py-3 text-base text-gray-900
                                placeholder:text-gray-400
                                outline-none transition
                                focus:border-[#c99b5b]
                                focus:ring-4 focus:ring-[#c99b5b]/10
                            "
                        >

                        <p class="mt-1.5 text-xs text-gray-500">
                            Usado para localizar o cliente.
                        </p>

                        @error('phone')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- E-mail --}}
                    <div>
                        <label
                            for="email"
                            class="mb-2 block text-sm font-semibold text-gray-800"
                        >
                            E-mail
                            <span class="ml-1 text-xs font-normal text-gray-400">
                                opcional
                            </span>
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="cliente@email.com"
                            autocomplete="email"
                            inputmode="email"
                            class="
                                block min-h-12 w-full rounded-xl border border-gray-200
                                bg-white px-4 py-3 text-base text-gray-900
                                placeholder:text-gray-400
                                outline-none transition
                                focus:border-[#c99b5b]
                                focus:ring-4 focus:ring-[#c99b5b]/10
                            "
                        >

                        <p class="mt-1.5 text-xs text-gray-500">
                            Opcional para futuras comunicações.
                        </p>

                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Data de nascimento --}}
                    <div>
                        <label
                            for="birth_date"
                            class="mb-2 block text-sm font-semibold text-gray-800"
                        >
                            Data de nascimento
                            <span class="ml-1 text-xs font-normal text-gray-400">
                                opcional
                            </span>
                        </label>

                        <input
                            id="birth_date"
                            name="birth_date"
                            type="date"
                            value="{{ old('birth_date') }}"
                            class="
                                block min-h-12 w-full rounded-xl border border-gray-200
                                bg-white px-4 py-3 text-base text-gray-900
                                outline-none transition
                                focus:border-[#c99b5b]
                                focus:ring-4 focus:ring-[#c99b5b]/10
                            "
                        >

                        <p class="mt-1.5 text-xs text-gray-500">
                            Útil para ações de aniversário.
                        </p>

                        @error('birth_date')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Observações --}}
                    <div>
                        <label
                            for="notes"
                            class="mb-2 block text-sm font-semibold text-gray-800"
                        >
                            Observações
                            <span class="ml-1 text-xs font-normal text-gray-400">
                                opcional
                            </span>
                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            maxlength="500"
                            placeholder="Ex.: Prefere atendimento à tarde."
                            class="
                                block min-h-12 w-full resize-none rounded-xl border border-gray-200
                                bg-white px-4 py-3 text-base text-gray-900
                                placeholder:text-gray-400
                                outline-none transition
                                focus:border-[#c99b5b]
                                focus:ring-4 focus:ring-[#c99b5b]/10
                            "
                        >{{ old('notes') }}</textarea>

                        <p class="mt-1.5 text-xs text-gray-500">
                            Alguma informação importante para o atendimento.
                        </p>

                        @error('notes')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Checkbox --}}
                    <div class="md:col-span-2">
                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-[#eadfce] bg-[#fcfaf7] p-4">
                            <input
                                type="checkbox"
                                name="send_whatsapp"
                                value="1"
                                checked
                                class="mt-0.5 h-4 w-4 rounded border-gray-300 text-[#b8894a] focus:ring-[#c99b5b]"
                            >

                            <span>
                                <span class="block text-sm font-semibold text-gray-800">
                                    Enviar cartão pelo WhatsApp
                                </span>

                                <span class="mt-1 block text-xs leading-5 text-gray-500">
                                    O cliente receberá um link para acessar o cartão digital.
                                </span>
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Ações --}}
                <div class="mt-7 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        onclick="history.back()"
                        class="
                            inline-flex min-h-12 items-center justify-center
                            rounded-xl border border-gray-200 bg-white
                            px-5 py-3 text-sm font-semibold text-gray-700
                            transition hover:bg-gray-50
                        "
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="barber-button-gold min-h-12 px-6"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 4.5v15m7.5-7.5h-15"
                            />
                        </svg>

                        Criar cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
