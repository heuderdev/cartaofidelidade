<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Convite indisponível</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>

<body class="min-h-screen bg-gray-100 antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="w-full max-w-md rounded-2xl bg-white p-8 text-center shadow-sm">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8 text-amber-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v3.75m0 3.75h.008M10.29 3.86l-7.2 12.48A1.75 1.75 0 004.6 19h14.8a1.75 1.75 0 001.51-2.66l-7.2-12.48a1.75 1.75 0 00-3.02 0z"
                    />
                </svg>
            </div>

            <p class="text-sm font-semibold uppercase tracking-wide text-amber-600">
                Convite indisponível
            </p>

            <h1 class="mt-3 text-2xl font-bold text-gray-900">
                Este convite não está mais disponível
            </h1>

            <p class="mt-4 text-sm leading-6 text-gray-600">
                O convite pode ter expirado, sido revogado ou já ter sido utilizado.
                Solicite um novo convite ao responsável pela empresa.
            </p>

            <div class="mt-8">
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                >
                    Voltar para o início
                </a>
            </div>
        </section>
    </main>
</body>
</html>
