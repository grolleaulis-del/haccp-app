<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Familles Produit') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Formulaire de création --}}
            <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    ➕ Ajouter une famille
                </h3>
                <form action="{{ route('familles.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <div class="md:col-span-2">
                            <label for="emoji" class="block text-sm font-medium text-gray-700 mb-1">Emoji</label>
                            <input type="text" name="emoji" id="emoji" maxlength="10"
                                   value="{{ old('emoji') }}"
                                   class="w-full rounded-lg border-gray-300 text-center text-2xl @error('emoji') border-red-500 @enderror"
                                   placeholder="🥩">
                        </div>
                        <div class="md:col-span-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                            <input type="text" name="nom" id="nom" required
                                   value="{{ old('nom') }}"
                                   class="w-full rounded-lg border-gray-300 @error('nom') border-red-500 @enderror"
                                   placeholder="Ex: Viandes, Poissons...">
                            @error('nom')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input type="text" name="description" id="description"
                                   value="{{ old('description') }}"
                                   class="w-full rounded-lg border-gray-300"
                                   placeholder="Description optionnelle...">
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg font-bold shadow hover:bg-blue-700 transition">
                                Ajouter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Liste des familles --}}
            <div class="space-y-3">
                @forelse($familles as $famille)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition"
                     x-data="{ editing: false }">

                    {{-- Mode affichage --}}
                    <div x-show="!editing" class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <span class="text-2xl flex-shrink-0">{{ $famille->emoji ?? '📦' }}</span>
                            <div class="min-w-0">
                                <h4 class="font-bold text-gray-900 truncate">{{ $famille->nom }}</h4>
                                @if($famille->description)
                                    <p class="text-sm text-gray-500 truncate">{{ $famille->description }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded-full font-medium">
                                {{ $famille->nb_produits }} produit{{ $famille->nb_produits > 1 ? 's' : '' }}
                            </span>
                            <button @click="editing = true" class="text-blue-600 hover:text-blue-800 p-1" title="Modifier">
                                ✏️
                            </button>
                            @if($famille->nb_produits === 0)
                            <form action="{{ route('familles.destroy', $famille) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Supprimer cette famille ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Supprimer">
                                    🗑️
                                </button>
                            </form>
                            @else
                            <span class="text-gray-300 p-1 cursor-not-allowed" title="Impossible de supprimer : des produits sont rattachés">
                                🗑️
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Mode édition --}}
                    <div x-show="editing" x-cloak class="p-4 bg-blue-50">
                        <form action="{{ route('familles.update', $famille) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Emoji</label>
                                    <input type="text" name="emoji" maxlength="10"
                                           value="{{ $famille->emoji }}"
                                           class="w-full rounded-lg border-gray-300 text-center text-2xl">
                                </div>
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Nom</label>
                                    <input type="text" name="nom" required
                                           value="{{ $famille->nom }}"
                                           class="w-full rounded-lg border-gray-300">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                                    <input type="text" name="description"
                                           value="{{ $famille->description }}"
                                           class="w-full rounded-lg border-gray-300">
                                </div>
                                <div class="md:col-span-3 flex gap-2">
                                    <button type="submit" class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg font-bold text-sm hover:bg-blue-700 transition">
                                        Sauver
                                    </button>
                                    <button type="button" @click="editing = false" class="flex-1 bg-gray-200 text-gray-700 px-3 py-2 rounded-lg font-bold text-sm hover:bg-gray-300 transition">
                                        Annuler
                                    </button>
                                </div>
                            </div>
                            @if($famille->nb_produits > 0)
                            <p class="text-xs text-blue-600 mt-2">
                                ⚠️ Renommer cette famille mettra à jour <strong>{{ $famille->nb_produits }}</strong> produit(s) automatiquement.
                            </p>
                            @endif
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-gray-400">
                    <p class="text-4xl mb-3">📂</p>
                    <p class="text-lg font-medium">Aucune famille créée</p>
                    <p class="text-sm">Ajoutez votre première famille ci-dessus</p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
