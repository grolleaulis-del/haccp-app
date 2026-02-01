<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arrivages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages flash --}}
            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Bouton créer --}}
            <div class="mb-6">
                <a href="{{ route('arrivages.create') }}"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                    + Nouvel arrivage
                </a>
            </div>

            {{-- Filtres --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('arrivages.index') }}"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">
                                Date début
                            </label>
                            <input type="date" name="date_debut" id="date_debut" value="{{ $date_debut }}"
                                class="w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">
                                Date fin
                            </label>
                            <input type="date" name="date_fin" id="date_fin" value="{{ $date_fin }}"
                                class="w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label for="fournisseur_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Fournisseur
                            </label>
                            <select name="fournisseur_id" id="fournisseur_id" class="w-full rounded-md border-gray-300">
                                <option value="">-- Tous --</option>
                                @foreach ($fournisseurs as $f)
                                    <option value="{{ $f->id }}"
                                        {{ $fournisseur_id == $f->id ? 'selected' : '' }}>
                                        {{ $f->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Filtrer
                        </button>
                    </form>
                </div>
            </div>

            {{-- Liste des arrivages --}}
            <div class="space-y-4">
                @forelse ($arrivages as $arrivage)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                {{-- Vignette photo --}}
                                @php
                                    $firstPhoto = $arrivage->lignes->where('photo_path', '!=', null)->first();
                                @endphp
                                @if ($firstPhoto)
                                    <div class="flex-shrink-0">
                                        <img src="{{ Storage::disk('public')->url($firstPhoto->photo_path) }}"
                                            alt="Photo"
                                            class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                                    </div>
                                @else
                                    <div
                                        class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">Pas de photo</span>
                                    </div>
                                @endif

                                {{-- Contenu --}}
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $arrivage->fournisseur->nom }} -
                                        {{ $arrivage->date_arrivage->format('d/m/Y') }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        <strong>Lignes:</strong> {{ $arrivage->lignes->count() }}
                                    </p>
                                    @if ($arrivage->commentaire)
                                        <p class="text-sm text-gray-600 mt-2">
                                            <strong>Commentaire:</strong> {{ $arrivage->commentaire }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex-shrink-0 flex gap-2">
                                    <a href="{{ route('arrivages.show', $arrivage) }}"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                        Voir
                                    </a>
                                    <a href="{{ route('arrivages.edit', $arrivage) }}"
                                        class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 text-sm">
                                        Éditer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            Aucun arrivage trouvé.
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $arrivages->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
