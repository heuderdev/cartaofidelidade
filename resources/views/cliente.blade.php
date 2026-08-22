@extends('layouts.barber')

@section('title', 'Dashboard')
@section('page-title', 'Clube de fidelidade')
@section('breadcrumb', 'Visão geral')

@section('content')
    @php
        $mockup = [
            'barbershop_name' => 'Barber Club',
            'card_name' => 'Clube do Corte',
            'card_subtitle' => 'Programa de fidelidade',
            'reward' => 'Corte grátis',
            'stamps_required' => 8,
            'stamps_completed' => 4,
            'customers' => 128,
            'stamps_distributed' => 642,
            'available_rewards' => 18,
            'redeemed_rewards' => 47,
            'public_url' => 'barberclub.test/fidelidade/barber-club',
        ];

        $progress = ($mockup['stamps_completed'] / $mockup['stamps_required']) * 100;
        $remaining_stamps = $mockup['stamps_required'] - $mockup['stamps_completed'];

        $recent_customers = [
            [
                'name' => 'Carlos Henrique',
                'phone' => '(61) 99999-1234',
                'stamps' => 7,
                'last_visit' => 'Hoje, 10:30',
                'initials' => 'CH',
            ],
            [
                'name' => 'Rafael Mendes',
                'phone' => '(61) 99888-4567',
                'stamps' => 5,
                'last_visit' => 'Hoje, 09:15',
                'initials' => 'RM',
            ],
            [
                'name' => 'Lucas Oliveira',
                'phone' => '(61) 99777-9876',
                'stamps' => 8,
                'last_visit' => 'Ontem, 16:40',
                'initials' => 'LO',
            ],
            [
                'name' => 'André Souza',
                'phone' => '(61) 99666-7412',
                'stamps' => 3,
                'last_visit' => 'Ontem, 14:20',
                'initials' => 'AS',
            ],
        ];

        $activities = [
            [
                'title' => 'Selo adicionado',
                'description' => 'Carlos Henrique recebeu 1 selo',
                'time' => 'Há 10 minutos',
                'type' => 'stamp',
            ],
            [
                'title' => 'Recompensa resgatada',
                'description' => 'Mariana Alves resgatou um corte grátis',
                'time' => 'Há 35 minutos',
                'type' => 'reward',
            ],
            [
                'title' => 'Novo cliente',
                'description' => 'Rafael Mendes criou um cartão',
                'time' => 'Há 1 hora',
                'type' => 'customer',
            ],
        ];
    @endphp

    <div class="space-y-6">
        {{-- Cabeçalho --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm text-gray-500">
                    Acompanhe o desempenho do seu cartão de fidelidade.
                </p>

                <p class="mt-1 text-xs text-gray-400">
                    Dados demonstrativos para visualização do sistema.
                </p>
            </div>

            <button
                type="button"
                class="
                    inline-flex items-center justify-center gap-2 rounded-xl
                    bg-[#171717] px-4 py-3 text-sm font-semibold text-white
                    transition hover:bg-[#2b2b2b]
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
                        d="M16.862 4.487 19.5 7.125M4.5 19.5l1.125-4.5L16.862 3.862a1.875 1.875 0 0 1 2.652 0l.624.624a1.875 1.875 0 0 1 0 2.652L8.9 18.375 4.5 19.5Z"
                    />
                </svg>

                Editar cartão
            </button>
        </div>

        {{-- Indicadores --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl bg-[#171717] p-5 text-white shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-400">
                            Clientes cadastrados
                        </p>

                        <p class="mt-3 font-serif text-3xl font-bold">
                            {{ $mockup['customers'] }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-[#c99b5b]/20 p-3 text-[#c99b5b]">
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
                                d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                            />
                        </svg>
                    </div>
                </div>

                <p class="mt-4 text-xs text-[#c99b5b]">
                    +12 clientes este mês
                </p>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500">
                            Selos distribuídos
                        </p>

                        <p class="mt-3 font-serif text-3xl font-bold text-[#171717]">
                            {{ $mockup['stamps_distributed'] }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-[#f7efe4] p-3 text-[#a4773e]">
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
                                d="M9 14.25 9.75 3.75 15 3l-.75 10.5L9 14.25ZM9 14.25 3 21m6-6.75L21 9"
                            />
                        </svg>
                    </div>
                </div>

                <p class="mt-4 text-xs text-gray-500">
                    Total acumulado
                </p>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500">
                            Recompensas disponíveis
                        </p>

                        <p class="mt-3 font-serif text-3xl font-bold text-[#171717]">
                            {{ $mockup['available_rewards'] }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
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
                                d="M12 3v18m9-9H3"
                            />
                        </svg>
                    </div>
                </div>

                <p class="mt-4 text-xs text-emerald-600">
                    Aguardando resgate
                </p>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500">
                            Recompensas resgatadas
                        </p>

                        <p class="mt-3 font-serif text-3xl font-bold text-[#171717]">
                            {{ $mockup['redeemed_rewards'] }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
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
                                d="m5 12 4 4L19 6"
                            />
                        </svg>
                    </div>
                </div>

                <p class="mt-4 text-xs text-gray-500">
                    Desde o início
                </p>
            </div>
        </div>

        {{-- Cartão e QR Code --}}
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            {{-- Preview do cartão --}}
            <section class="xl:col-span-2 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5 sm:p-6">
                <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                    <div>
                        <h2 class="font-serif text-xl font-bold text-[#171717]">
                            Meu cartão
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Visualização do cartão digital dos seus clientes.
                        </p>
                    </div>

                    <span class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Ativo
                    </span>
                </div>

                <div class="mt-6 max-w-2xl">
                    <div class="relative overflow-hidden rounded-3xl bg-[#171717] p-6 text-white shadow-xl sm:p-8">
                        <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full border-[24px] border-[#c99b5b]/10"></div>
                        <div class="absolute -bottom-24 -left-12 h-48 w-48 rounded-full border-[24px] border-[#c99b5b]/10"></div>

                        <div class="relative">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.3em] text-[#c99b5b]">
                                        {{ $mockup['card_subtitle'] }}
                                    </p>

                                    <h3 class="mt-3 font-serif text-2xl font-bold sm:text-3xl">
                                        {{ $mockup['card_name'] }}
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-400">
                                        {{ $mockup['barbershop_name'] }}
                                    </p>
                                </div>

                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#c99b5b] text-2xl text-[#171717]">
                                    ✂
                                </div>
                            </div>

                            <div class="mt-8 grid grid-cols-4 gap-3 sm:grid-cols-8">
                                @for ($i = 1; $i <= $mockup['stamps_required']; $i++)
                                    <div
                                        class="
                                            flex aspect-square items-center justify-center
                                            rounded-full border text-sm font-semibold
                                            {{ $i <= $mockup['stamps_completed']
                                                ? 'border-[#c99b5b] bg-[#c99b5b] text-[#171717]'
                                                : 'border-white/20 bg-white/5 text-gray-500' }}
                                        "
                                    >
                                        @if ($i <= $mockup['stamps_completed'])
                                            ✓
                                        @else
                                            {{ $i }}
                                        @endif
                                    </div>
                                @endfor
                            </div>

                            <div class="mt-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                                <div>
                                    <p class="text-sm text-gray-400">
                                        Progresso atual
                                    </p>

                                    <p class="mt-1 font-semibold">
                                        {{ $mockup['stamps_completed'] }}
                                        de
                                        {{ $mockup['stamps_required'] }}
                                        selos
                                    </p>
                                </div>

                                <div class="text-left sm:text-right">
                                    <p class="text-xs text-gray-400">
                                        Próxima recompensa
                                    </p>

                                    <p class="mt-1 font-medium text-[#e4bd83]">
                                        {{ $mockup['reward'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="mb-2 flex items-center justify-between text-xs text-gray-500">
                            <span>{{ $mockup['stamps_completed'] }} selos conquistados</span>
                            <span>{{ $mockup['stamps_required'] }} selos</span>
                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-gray-100">
                            <div
                                class="h-full rounded-full bg-[#c99b5b]"
                                style="width: {{ $progress }}%;"
                            ></div>
                        </div>

                        <p class="mt-2 text-xs text-gray-400">
                            Faltam {{ $remaining_stamps }} selos para liberar a recompensa.
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <button
                        type="button"
                        class="rounded-xl bg-[#c99b5b] px-4 py-3 text-sm font-semibold text-[#171717] hover:bg-[#b8894a]"
                    >
                        Editar cartão
                    </button>

                    <button
                        type="button"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        Ver cartão público
                    </button>
                </div>
            </section>

            {{-- Divulgação --}}
            <section class="rounded-2xl bg-[#30281e] p-5 text-white shadow-sm sm:p-6">
                <p class="text-sm text-[#d6c0a0]">
                    Divulgue seu cartão
                </p>

                <h2 class="mt-2 font-serif text-2xl font-bold">
                    Convide seus clientes
                </h2>

                <p class="mt-3 text-sm leading-6 text-[#d6c0a0]">
                    Mostre o QR Code no balcão, no espelho ou envie o link pelo WhatsApp.
                </p>

                {{-- QR Code mockup --}}
                <div class="mt-6 flex justify-center rounded-2xl bg-white p-6">
                    <div class="grid h-40 w-40 grid-cols-9 gap-1 bg-white p-2">
                        @php
                            $qrPattern = [
                                1,1,1,1,1,0,1,1,1,
                                1,0,0,0,1,1,1,0,1,
                                1,0,1,0,1,0,1,0,1,
                                1,0,0,0,1,1,1,0,1,
                                1,1,1,1,1,0,1,1,1,
                                0,1,0,1,0,1,0,1,0,
                                1,1,1,0,1,1,1,0,1,
                                1,0,0,1,0,1,0,1,1,
                                1,1,1,0,1,0,1,1,0,
                            ];
                        @endphp

                        @foreach ($qrPattern as $cell)
                            <span class="{{ $cell ? 'bg-[#171717]' : 'bg-white' }}"></span>
                        @endforeach
                    </div>
                </div>

                <p class="mt-4 break-all rounded-lg bg-black/20 p-3 text-center text-xs text-[#e5c895]">
                    {{ $mockup['public_url'] }}
                </p>

                <button
                    type="button"
                    onclick="navigator.clipboard.writeText('{{ $mockup['public_url'] }}')"
                    class="mt-4 w-full rounded-xl bg-[#c99b5b] px-4 py-3 text-sm font-semibold text-[#171717] transition hover:bg-[#b8894a]"
                >
                    Copiar link do cartão
                </button>

                <button
                    type="button"
                    class="mt-3 w-full rounded-xl border border-white/20 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                >
                    Baixar QR Code
                </button>
            </section>
        </div>

        {{-- Clientes e atividades --}}
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            {{-- Clientes recentes --}}
            <section class="xl:col-span-2 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-serif text-xl font-bold text-[#171717]">
                            Clientes recentes
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Acompanhe o progresso dos seus clientes.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="text-sm font-semibold text-[#a4773e] hover:text-[#7d592d]"
                    >
                        Ver todos
                    </button>
                </div>

                <div class="mt-5 overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs uppercase tracking-wider text-gray-400">
                                <th class="pb-3 font-medium">Cliente</th>
                                <th class="pb-3 font-medium">Última visita</th>
                                <th class="pb-3 font-medium">Progresso</th>
                                <th class="pb-3 text-right font-medium">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($recent_customers as $customer)
                                @php
                                    $customerProgress = ($customer['stamps'] / $mockup['stamps_required']) * 100;
                                @endphp

                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#f1e5d5] text-xs font-bold text-[#9a6d35]">
                                                {{ $customer['initials'] }}
                                            </div>

                                            <div>
                                                <p class="font-semibold text-[#171717]">
                                                    {{ $customer['name'] }}
                                                </p>

                                                <p class="mt-1 text-xs text-gray-500">
                                                    {{ $customer['phone'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-4 text-sm text-gray-500">
                                        {{ $customer['last_visit'] }}
                                    </td>

                                    <td class="py-4">
                                        <div class="w-32">
                                            <div class="mb-1 flex justify-between text-xs text-gray-500">
                                                <span>{{ $customer['stamps'] }}/{{ $mockup['stamps_required'] }}</span>
                                                <span>{{ round($customerProgress) }}%</span>
                                            </div>

                                            <div class="h-1.5 overflow-hidden rounded-full bg-gray-100">
                                                <div
                                                    class="h-full rounded-full bg-[#c99b5b]"
                                                    style="width: {{ $customerProgress }}%;"
                                                ></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-4 text-right">
                                        @if ($customer['stamps'] >= $mockup['stamps_required'])
                                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
                                                Recompensa
                                            </span>
                                        @else
                                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                                Em andamento
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Atividades --}}
            <section class="rounded-2xl bg-[#171717] p-5 text-white shadow-sm sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-serif text-xl font-bold">
                            Atividade recente
                        </h2>

                        <p class="mt-1 text-sm text-gray-400">
                            Últimas movimentações
                        </p>
                    </div>

                    <div class="rounded-xl bg-white/10 p-2 text-[#c99b5b]">
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
                                d="M12 6v6l4 2"
                            />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </div>
                </div>

                <div class="mt-6 space-y-5">
                    @foreach ($activities as $activity)
                        <div class="flex gap-3">
                            <div
                                class="
                                    flex h-9 w-9 shrink-0 items-center justify-center rounded-full
                                    {{ $activity['type'] === 'reward'
                                        ? 'bg-emerald-500/15 text-emerald-400'
                                        : ($activity['type'] === 'customer'
                                            ? 'bg-blue-500/15 text-blue-400'
                                            : 'bg-[#c99b5b]/15 text-[#c99b5b]') }}
                                "
                            >
                                @if ($activity['type'] === 'reward')
                                    ✓
                                @elseif ($activity['type'] === 'customer')
                                    +
                                @else
                                    ✂
                                @endif
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-medium text-white">
                                    {{ $activity['title'] }}
                                </p>

                                <p class="mt-1 text-xs leading-5 text-gray-400">
                                    {{ $activity['description'] }}
                                </p>

                                <p class="mt-1 text-[11px] text-gray-500">
                                    {{ $activity['time'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button
                    type="button"
                    class="mt-7 w-full rounded-xl border border-white/10 px-4 py-3 text-sm font-semibold text-gray-300 transition hover:bg-white/10 hover:text-white"
                >
                    Ver histórico completo
                </button>
            </section>
        </div>
    </div>
@endsection
