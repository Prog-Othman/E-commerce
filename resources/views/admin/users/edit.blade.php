@extends('layouts.app')

@section('title', 'Modifier l\'Utilisateur')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <div class="w-64 h-screen sticky top-0">
        @include('partials.sidebar')
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-x-hidden">
        <!-- Header -->
        <div class="sticky top-0 z-10">
            @include('partials.header')
        </div>

        <div class="p-8">
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-semibold text-gray-900">Modifier l'utilisateur</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        <span class="material-icons mr-2 text-base">arrow_back</span>
                        Retour à la liste
                    </a>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <span class="material-icons mr-2 text-base">delete</span>
                                Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Informations de l'utilisateur</h3>
                                <p class="mt-1 text-sm text-gray-500">Mettez à jour les informations de l'utilisateur.</p>
                            </div>

                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                                    <div class="mt-1">
                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                                    <div class="mt-1">
                                        <input type="password" name="password" id="password"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                                    <div class="mt-1">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rôles</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach($roles as $role)
                                            <div class="flex items-center">
                                                <input id="role-{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->name }}"
                                                    {{ in_array($role->name, $user->roles->pluck('name')->toArray()) ? 'checked' : '' }}
                                                    class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                                <label for="role-{{ $role->id }}" class="ml-3 block text-sm font-medium text-gray-700">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-5">
                            <div class="flex justify-end">
                                <button type="button" onclick="window.history.back()" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Annuler
                                </button>
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
