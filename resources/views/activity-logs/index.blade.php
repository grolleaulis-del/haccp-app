<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🕵️ Boîte Noire - Historique des Activités
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filtres --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Filtres</h3>

                    <form method="GET" action="{{ route('activity-logs.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                                <input type="date" name="date_debut" value="{{ $filters['date_debut'] ?? '' }}"
                                    class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                                <input type="date" name="date_fin" value="{{ $filters['date_fin'] ?? '' }}"
                                    class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                                <select name="module" class="w-full rounded-md border-gray-300">
                                    <option value="">-- Tous --</option>
                                    @foreach ($modules as $module)
                                        <option value="{{ $module }}" {{ ($filters['module'] ?? '') == $module ? 'selected' : '' }}>
                                            {{ ucfirst($module) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                                <select name="action" class="w-full rounded-md border-gray-300">
                                    <option value="">-- Toutes --</option>
                                    @foreach ($actions as $action)
                                        <option value="{{ $action }}" {{ ($filters['action'] ?? '') == $action ? 'selected' : '' }}>
                                            {{ ucfirst($action) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Utilisateur</label>
                                <select name="user_id" class="w-full rounded-md border-gray-300">
                                    <option value="">-- Tous --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ ($filters['user_id'] ?? '') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Filtrer
                            </button>
                            <a href="{{ route('activity-logs.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Statistiques --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Total d'activités</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $logs->total() }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Aujourd'hui</div>
                    <div class="text-3xl font-bold text-blue-600">
                        {{ \App\Models\ActivityLog::whereDate('created_at', today())->count() }}
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Utilisateurs actifs</div>
                    <div class="text-3xl font-bold text-green-600">
                        {{ \App\Models\ActivityLog::whereDate('created_at', today())->distinct('user_id')->count('user_id') }}
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Modules utilisés</div>
                    <div class="text-3xl font-bold text-purple-600">
                        {{ \App\Models\ActivityLog::whereDate('created_at', today())->distinct('module')->count('module') }}
                    </div>
                </div>
            </div>

            {{-- Liste des logs --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900 mb-4">
                        Historique ({{ $logs->total() }} entrées)
                    </h3>

                    @if ($logs->isEmpty())
                        <p class="text-gray-500 text-center py-8">Aucune activité trouvée</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date/Heure</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Module</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($logs as $log)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $log->user->name ?? 'Système' }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                    {{ ucfirst($log->module) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                                @if($log->action === 'create')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                        ➕ {{ ucfirst($log->action) }}
                                                    </span>
                                                @elseif($log->action === 'update')
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                                        ✏️ {{ ucfirst($log->action) }}
                                                    </span>
                                                @elseif($log->action === 'delete')
                                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                                        🗑️ {{ ucfirst($log->action) }}
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                                        {{ ucfirst($log->action) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                {{ $log->description }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                {{ $log->ip_address }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $logs->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
