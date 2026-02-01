<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏷️ Sélectionner le produit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Photo capturée (ou absence) --}}
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900">Photo du produit tracé</h3>
                            @if(!empty($photoData))
                                <div class="flex justify-center">
                                    <img src="{{ $photoData }}" alt="Étiquette"
                                         class="w-40 h-40 object-cover rounded-lg border-2 border-gray-300">
                                </div>
                            @else
                                <div class="p-4 border-2 border-dashed border-gray-300 rounded-lg text-center text-gray-500">
                                    Pas de photo fournie
                                </div>
                            @endif
                            @if(!empty($skipPhoto))
                                <div class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                                    Étape photo ignorée
                                </div>
                            @endif

                            {{-- Boutons d'action --}}
                            <div class="space-y-2 pt-4 border-t">
                                <a href="{{ route('scan-etiquette.index') }}"
                                   class="block w-full px-4 py-3 bg-gray-600 text-white text-center font-semibold rounded-lg hover:bg-gray-700 transition">
                                    ← Reprendre photo
                                </a>
                                <button type="submit" form="selectProduitForm"
                                        class="w-full px-4 py-3 bg-green-600 text-white text-center font-semibold rounded-lg hover:bg-green-700 transition">
                                    💾 Enregistrer le lot
                                </button>

                                {{-- Commentaire optionnel déplacé ici --}}
                                <div class="mt-3">
                                    <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                                        Commentaire (optionnel)
                                    </label>
                                    <textarea form="selectProduitForm" name="commentaire" id="commentaire" rows="2"
                                              class="w-full rounded-md border-gray-300"
                                              placeholder="Informations complémentaires..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Liste des produits par catégorie --}}
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                Sélectionnez le produit correspondant
                            </h3>

                            <form method="POST" action="{{ route('scan-etiquette.store-lot') }}" id="selectProduitForm">
                                @csrf
                                <input type="hidden" name="photo" value="{{ $photoData }}">
                                <input type="hidden" name="skip_photo" value="{{ !empty($skipPhoto) ? 1 : 0 }}">



                                {{-- Recherche produit --}}
                                <div class="mb-4">
                                    <input type="text"
                                           id="searchProduct"
                                           placeholder="Rechercher un produit..."
                                           class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                {{-- Produits groupés par famille --}}
                                <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2">
                                    @php
                                        $produitsParFamille = $produits->groupBy('famille');
                                    @endphp

                                    @foreach($produitsParFamille as $famille => $produitsGroupe)
                                        <div>
                                            <h4 class="text-md font-bold text-gray-800 mb-3 bg-gray-100 px-3 py-2 rounded">
                                                {{ $famille }}
                                            </h4>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 ml-2">
                                                @foreach($produitsGroupe as $produit)
                                                    <label class="relative cursor-pointer group produit-card" data-product-name="{{ strtolower($produit->nom) }}">
                                                        <input type="radio"
                                                               name="produit_id"
                                                               value="{{ $produit->id }}"
                                                               class="peer sr-only"
                                                               required>
                                                        <div class="p-4 border-2 border-gray-300 rounded-lg hover:border-blue-500 peer-checked:border-green-600 peer-checked:bg-green-50 transition-all">
                                                            <div class="text-center">
                                                                <div class="text-3xl mb-2">
                                                                    @if($produit->lotActif)
                                                                        ✅
                                                                    @else
                                                                        📦
                                                                    @endif
                                                                </div>
                                                                <div class="text-sm font-semibold text-gray-900">
                                                                    {{ $produit->nom }}
                                                                </div>
                                                                @if($produit->lotActif)
                                                                    <div class="text-xs text-green-600 mt-1">
                                                                        Lot actif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchProduct');
    if (!searchInput) return;
    const cards = Array.from(document.querySelectorAll('.produit-card'));

    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase().trim();
        cards.forEach(card => {
            const name = card.getAttribute('data-product-name');
            card.style.display = name.includes(term) ? '' : 'none';
        });
    });
});
</script>

