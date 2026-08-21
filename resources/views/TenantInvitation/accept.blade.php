@extends('layouts.default')

@section('title', 'Aceitar convite')

@section('content')
    <div class="mx-auto flex min-h-screen max-w-xl items-center px-4 py-10">
        <div class="w-full rounded-xl bg-white p-6 shadow-sm">
            <h1 class="text-xl font-semibold text-gray-900">
                Aceitar convite
            </h1>

            <p class="mt-3 text-sm text-gray-600">
                Você foi convidado para entrar em
                <strong>{{ $invitation->tenant->name }}</strong>
                como
                <strong>{{ $invitation->role }}</strong>.
            </p>

            <form
                method="POST"
                action="{{ route('tenant-invitation.confirm', [
                    'invitation' => $invitation->getKey(),
                    'token' => $token,
                ]) }}"
                class="mt-6 flex gap-3"
            >
                @csrf

                <button
                    type="submit"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
                >
                    Aceitar convite
                </button>

                <a
                    href="{{ route('dashboard') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                >
                    Cancelar
                </a>
            </form>
        </div>
    </div>
@endsection
