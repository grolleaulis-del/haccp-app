<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Arrivage du {{ $arrivage->date_arrivage->format('d/m/Y') }} - {{ $arrivage->fournisseur->nom }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('arrivages.edit', $arrivage) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 font-medium text-sm">
                    Éditer
                </a>
                <a href="{{ route('arrivages.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-medium text-sm">
                    Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Infos arrivage --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Fournisseur</p>
                            <p class="font-medium text-gray-900">{{ $arrivage->fournisseur->nom }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date</p>
                            <p class="font-medium text-gray-900">{{ $arrivage->date_arrivage->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    @if ($arrivage->bl_path)
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Bon de livraison</p>
                            <a href="{{ Storage::disk('public')->url($arrivage->bl_path) }}" target="_blank" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                📄 Télécharger
                            </a>
                        </div>
                    @endif

                    @if ($arrivage->commentaire)
                        <div>
                            <p class="text-sm text-gray-500">Commentaire</p>
                            <p class="text-gray-700">{{ $arrivage->commentaire }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Lignes --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="font-semibold text-lg text-gray-900 mb-4">
                        Produits reçus ({{ $arrivage->lignes->count() }})
                    </h3>

                    @if ($arrivage->lignes->isEmpty())
                        <p class="text-gray-500 text-center py-8">Aucun produit reçu</p>
                    @else
                        <div class="space-y-4">
                            @foreach ($arrivage->lignes as $ligne)
                                <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $ligne->produit->nom }}</h4>
                                        <p class="text-sm text-gray-500">{{ $ligne->produit->famille }}</p>

                                        @if ($ligne->numero_lot)
                                            <p class="text-sm text-gray-700 mt-2">
                                                <strong>Lot:</strong> {{ $ligne->numero_lot }}
                                            </p>
                                        @endif

                                        @if ($ligne->photo_path)
                                            <p class="mt-2">
                                                <a href="{{ Storage::disk('public')->url($ligne->photo_path) }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm">
                                                    🖼️ Voir photo
                                                </a>
                                            </p>
                                        @endif

                                        @if ($ligne->commentaire)
                                            <p class="text-sm text-gray-700 mt-2">{{ $ligne->commentaire }}</p>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-400">{{ $ligne->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <button type="button" class="mt-6 text-blue-600 hover:text-blue-700 text-sm font-medium" onclick="toggleAddLigneForm()">
                        + Ajouter une ligne
                    </button>
                </div>
            </div>

            {{-- Formulaire ajout ligne (caché) --}}
            <div id="add-ligne-form" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hidden">
                <div class="p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Ajouter une ligne</h4>

                    <form method="POST" action="{{ route('arrivages.addLigne', $arrivage) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Produit <span class="text-red-600">*</span>
                                </label>
                                <select name="produit_id" required class="w-full rounded-md border-gray-300">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($produits as $p)
                                        <option value="{{ $p->id }}">{{ $p->nom }} ({{ $p->famille }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Numéro lot
                                </label>
                                <input type="text" name="numero_lot" placeholder="ex: LOT123" class="w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Photo étiquette
                                </label>
                                <input type="file" name="photo" accept="image/*" class="w-full rounded-md border-gray-300">
                                <p class="text-xs text-gray-500 mt-1">Max 5 MB</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Commentaire
                                </label>
                                <input type="text" name="commentaire" class="w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium">
                                Ajouter
                            </button>
                            <button type="button" onclick="toggleAddLigneForm()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 text-sm font-medium">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleAddLigneForm() {
            document.getElementById('add-ligne-form').classList.toggle('hidden');
        }
    </script>
</x-app-layout>
