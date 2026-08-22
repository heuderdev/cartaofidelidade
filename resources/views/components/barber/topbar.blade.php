<header class="flex h-20 shrink-0 items-center justify-between border-b border-[#e5e0d8] bg-[#f5f3ef] px-4 sm:px-6 lg:px-10">
    <div class="flex min-w-0 items-center">
        <button
            type="button"
            @click="sidebarOpen = true"
            class="mr-3 rounded-xl p-2 text-gray-600 hover:bg-white lg:hidden"
            aria-label="Abrir menu"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </button>

        <div class="min-w-0">
            <p class="text-xs font-medium uppercase tracking-[0.18em] text-gray-500">
                @yield('breadcrumb', 'Visão geral')
            </p>

            <h1 class="mt-1 truncate font-serif text-2xl font-bold text-[#171717]">
                @yield('page-title', 'Dashboard')
            </h1>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button
            type="button"
            class="relative rounded-xl bg-white p-2.5 text-gray-600 shadow-sm hover:text-[#a4773e]"
            aria-label="Notificações"
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
                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9a6 6 0 0 0-12 0v.75a8.967 8.967 0 0 1-2.31 6.022c1.733.64 3.55 1.085 5.453 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                />
            </svg>

            <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-[#c99b5b]"></span>
        </button>

        <div class="hidden text-right sm:block">
            <p class="text-sm font-semibold text-[#171717]">
                Administrador
            </p>

            <p class="text-xs text-gray-500">
                Barber Club
            </p>
        </div>

        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#171717] font-semibold text-[#c99b5b]">
            A
        </div>
    </div>
</header>
