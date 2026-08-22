<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Barber Club')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

    @livewireStyles

    @stack('styles')
</head>

<body class="h-screen overflow-hidden bg-[#f5f3ef] text-[#171717] antialiased">
    <div
        x-data="{ sidebarOpen: false }"
        class="flex h-screen overflow-hidden"
    >
        {{-- Overlay mobile --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/60 lg:hidden"
            style="display: none;"
        ></div>

        {{-- Menu lateral --}}
        <x-barber.sidebar />

        {{-- Área principal --}}
        <div class="flex min-w-0 flex-1 flex-col overflow-hidden">
            <x-barber.topbar />

            <main class="min-h-0 flex-1 overflow-y-auto">
                <div class="mx-auto w-full max-w-screen-2xl p-4 sm:p-6 lg:p-10">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @livewireScripts

    @stack('scripts')
</body>
</html>
