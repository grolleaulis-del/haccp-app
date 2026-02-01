<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👥 Gestion des Utilisateurs
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    ← Administration
                </a>
                <a href="{{ route('users.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    + Nouvel utilisateur
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form id="deleteMultipleForm" method="POST" action="{{ route('users.destroy.multiple') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer les utilisateurs sélectionnés ?')">
                        @csrf

                        {{-- Barre d'actions --}}
                        <div class="mb-4 p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center rounded-lg">
                            <div class="flex items-center gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" id="selectAll"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Tout sélectionner</span>
                                </label>
                                <span id="selectedCount" class="text-sm text-gray-600">0 utilisateur(s) sélectionné(s)</span>
                            </div>
                            <button type="submit" id="deleteSelectedBtn"
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                🗑️ Supprimer la sélection
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                            <span class="sr-only">Sélectionner</span>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Utilisateur
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Rôle
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Dernière Connexion
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($users as $user)
                                        <tr class="hover:bg-gray-50 {{ !$user->is_active ? 'bg-gray-100' : '' }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($user->id !== auth()->id())
                                                    <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                                           class="user-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full {{ $user->role === 'admin' ? 'bg-red-600' : ($user->role === 'manager' ? 'bg-purple-600' : 'bg-blue-600') }} flex items-center justify-center text-white font-bold">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $user->name }}
                                                        </div>
                                                        @if($user->id === auth()->id())
                                                            <span class="text-xs text-green-600">(Vous)</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->role === 'admin')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        👑 Admin
                                                    </span>
                                                @elseif($user->role === 'manager')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                        ⭐ Manager
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        👤 Employé
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->is_active)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        ✓ Actif
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        ✗ Désactivé
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                                @if($user->last_login_at)
                                                    <div>{{ $user->last_login_at->format('d/m/Y H:i') }}</div>
                                                    <div class="text-xs text-gray-400">{{ $user->last_login_ip }}</div>
                                                @else
                                                    <span class="text-gray-400">Jamais</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                <a href="{{ route('users.edit', $user) }}"
                                                   class="text-blue-600 hover:text-blue-900">
                                                    Modifier
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                            {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- Script pour gérer la sélection --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const deleteBtn = document.getElementById('deleteSelectedBtn');
            const selectedCountSpan = document.getElementById('selectedCount');

            // Fonction pour mettre à jour le compteur et l'état du bouton
            function updateSelectedCount() {
                const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
                selectedCountSpan.textContent = `${checkedCount} utilisateur(s) sélectionné(s)`;
                deleteBtn.disabled = checkedCount === 0;

                // Mettre à jour l'état de "Tout sélectionner"
                selectAllCheckbox.checked = checkedCount === userCheckboxes.length && checkedCount > 0;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < userCheckboxes.length;
            }

            // Tout sélectionner / Tout désélectionner
            selectAllCheckbox.addEventListener('change', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedCount();
            });

            // Gérer le changement de chaque case à cocher
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Initialiser le compteur
            updateSelectedCount();
        });
    </script>
</x-app-layout>
