<aside
    class="
        fixed inset-y-0 left-0 z-50
        flex w-72 shrink-0 -translate-x-full flex-col
        bg-[#171717] text-white
        transition-transform duration-300 ease-in-out
        lg:static lg:z-auto lg:translate-x-0
    "
    :class="{ 'translate-x-0': sidebarOpen }"
>
    {{-- Cabeçalho --}}
    <div class="flex h-20 shrink-0 items-center justify-between border-b border-white/10 px-6">
        <x-barber.logo />

        <button
            type="button"
            @click="sidebarOpen = false"
            class="rounded-lg p-2 text-gray-400 hover:bg-white/10 hover:text-white lg:hidden"
            aria-label="Fechar menu"
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
                    d="M6 18 18 6M6 6l12 12"
                />
            </svg>
        </button>
    </div>

    {{-- Perfil --}}
    <x-barber.sidebar-profile />

    {{-- Navegação --}}
    <nav class="min-h-0 flex-1 overflow-y-auto px-4 py-6">
        <div class="space-y-8">
            <x-barber.sidebar-section title="Menu principal">
                <x-barber.sidebar-menu-item
                    label="Dashboard"
                    href="/"
                    :active="true"
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
                            d="m3 12 9-9 9 9M5 10v10h14V10"
                        />
                    </svg>
                </x-barber.sidebar-menu-item>

                <x-barber.sidebar-menu-item
                    label="Clientes"
                    href="#"
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
                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0-0-8 4 4 0 0 0 0 8Zm11 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
                        />
                    </svg>
                </x-barber.sidebar-menu-item>

            </x-barber.sidebar-section>

            <x-barber.sidebar-section title="Administração">
                <x-barber.sidebar-menu-item
                    label="Configurações"
                    href="#"
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
                            d="M10.5 6h3m-7.5 6h12m-12 6h12M6.75 3h10.5A2.25 2.25 0 0 1 19.5 5.25v13.5A2.25 2.25 0 0 1 17.25 21H6.75a2.25 2.25 0 0 1-2.25-2.25V5.25A2.25 2.25 0 0 1 6.75 3Z"
                        />
                    </svg>
                </x-barber.sidebar-menu-item>
            </x-barber.sidebar-section>
        </div>
    </nav>

    {{-- Rodapé --}}
    <div class="shrink-0 border-t border-white/10 p-4">
        <button
            type="button"
            class="
                flex w-full items-center gap-3 rounded-xl px-3 py-3
                text-sm text-gray-400 transition
                hover:bg-red-500/10 hover:text-red-400
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
                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M18 15l3-3m0 0-3-3m3 3H9"
                />
            </svg>

            <span>Sair da conta</span>
        </button>
    </div>
</aside>
