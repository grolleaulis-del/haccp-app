<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contrôle Arrivages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filtres --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Filtres</h3>

                    <form method="GET" action="{{ route('controle.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                                <input type="date" name="date_debut" value="{{ $date_debut }}"
                                    class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                                <input type="date" name="date_fin" value="{{ $date_fin }}"
                                    class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fournisseur</label>
                                <select name="fournisseur_id" class="w-full rounded-md border-gray-300">
                                    <option value="">-- Tous --</option>
                                    @foreach ($fournisseurs as $f)
                                        <option value="{{ $f->id }}"
                                            {{ $fournisseur_id == $f->id ? 'selected' : '' }}>
                                            {{ $f->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Type d'opération</label>
                                <select name="type_operation" class="w-full rounded-md border-gray-300">
                                    <option value="">-- Tous --</option>
                                    <option value="usage" {{ $type_operation == 'usage' ? 'selected' : '' }}>Usage quotidien</option>
                                    <option value="cuisson" {{ $type_operation == 'cuisson' ? 'selected' : '' }}>Cuisson</option>
                                    <option value="congelation" {{ $type_operation == 'congelation' ? 'selected' : '' }}>Congélation</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Filtrer
                            </button>
                            <a href="{{ route('controle.export-pdf', request()->query()) }}"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                📄 Export PDF Global
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Liste des Lots --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900 mb-4">
                        📦 Lots d'utilisation ({{ $lots->total() }})
                    </h3>

                    @if ($lots->isEmpty())
                        <p class="text-gray-500 text-center py-8">Aucun lot trouvé</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Lot</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">DLC</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($lots as $lot)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $lot->started_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($lot->type_operation === 'cuisson')
                                                    <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">
                                                        🔥 Cuisson
                                                    </span>
                                                @elseif($lot->type_operation === 'congelation')
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                        ❄️ Congélation
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                        ✅ Usage
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $lot->produit->nom ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $lot->numero_lot ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($lot->dlc)
                                                    <span class="{{ $lot->dlc < now() ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                                                        {{ $lot->dlc->format('d/m/Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $lot->user->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($lot->photo_etiquette)
                                                    <a href="{{ asset('storage/' . $lot->photo_etiquette) }}"
                                                       target="_blank"
                                                       class="block hover:opacity-80">
                                                        <img src="{{ asset('storage/' . $lot->photo_etiquette) }}"
                                                             alt="Photo"
                                                             class="w-16 h-16 object-cover rounded border border-gray-200">
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <form method="POST" action="{{ route($lot->type_operation === 'cuisson' ? 'cuisson-refroidissement.destroy' : 'lots.destroy', $lot) }}"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce lot ?');"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900 font-medium">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $lots->links() }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Liste des Arrivages --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900 mb-4">
                        📦 Arrivages ({{ $arrivages->total() }})
                    </h3>

                    @if ($arrivages->isEmpty())
                        <p class="text-gray-500 text-center py-8">Aucun arrivage trouvé</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Fournisseur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Lignes</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">BL
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($arrivages as $arrivage)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $arrivage->date_arrivage->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $arrivage->fournisseur->nom }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $arrivage->lignes->count() }} produit(s)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if ($arrivage->bl_path)
                                                    <span class="text-green-600">✓ Oui</span>
                                                @else
                                                    <span class="text-gray-400">- Non</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex gap-2">
                                                    <a href="{{ route('arrivages.show', $arrivage) }}"
                                                        class="text-blue-600 hover:text-blue-700">
                                                        👁️ Voir
                                                    </a>
                                                    <a href="{{ route('controle.pdf', $arrivage) }}"
                                                        class="text-red-600 hover:text-red-700">
                                                        📄 PDF
                                                    </a>
                                                    <a href="{{ route('controle.zip', $arrivage) }}"
                                                        class="text-purple-600 hover:text-purple-700">
                                                        📦 ZIP
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $arrivages->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
