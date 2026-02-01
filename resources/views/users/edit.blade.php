<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Modifier l'utilisateur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Nom --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom complet <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full rounded-md border-gray-300"
                                   required autofocus>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-600">*</span>
                            </label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full rounded-md border-gray-300"
                                   required>
                        </div>

                        {{-- Rôle --}}
                        @if(auth()->user()->isAdmin())
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                Rôle <span class="text-red-600">*</span>
                            </label>
                            <select name="role" id="role" class="w-full rounded-md border-gray-300" required>
                                <option value="employe" {{ old('role', $user->role) === 'employe' ? 'selected' : '' }}>
                                    👤 Employé - Accès aux fonctionnalités quotidiennes
                                </option>
                                <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>
                                    ⭐ Manager - Gestion + visualisation des logs
                                </option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    👑 Admin - Accès complet au système
                                </option>
                            </select>
                        </div>

                        {{-- Statut actif --}}
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                       {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                       {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Compte actif</span>
                            </label>
                            @if($user->id === auth()->id())
                                <p class="text-xs text-gray-500 mt-1">Vous ne pouvez pas désactiver votre propre compte</p>
                            @endif
                        </div>
                        @endif

                        {{-- Mot de passe (optionnel) --}}
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-4">
                                Laissez vide pour conserver le mot de passe actuel
                            </p>

                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nouveau mot de passe
                                </label>
                                <input type="password" name="password" id="password"
                                       class="w-full rounded-md border-gray-300">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmer le nouveau mot de passe
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('users.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                💾 Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
