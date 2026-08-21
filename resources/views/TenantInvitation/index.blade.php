@extends('layouts.default')

@section('title', 'Convidar funcionário')

@section('content')
    <div class="mx-auto max-w-xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h1 class="mb-6 text-xl font-semibold text-gray-900">
                Convidar funcionário
            </h1>

            <livewire:tenant-invitation.create />
        </div>
    </div>
@endsection
