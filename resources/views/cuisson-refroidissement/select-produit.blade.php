<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sélectionner le produit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Photo capturée --}}
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900">Photo de l'étiquette</h3>
                            <div class="flex justify-center">
                                <img src="{{ $photoData }}" alt="étiquette"
                                     class="w-40 h-40 object-cover rounded-lg border-2 border-gray-300">
                            </div>

                            {{-- Commentaire optionnel --}}
                            <div class="mt-3">
                                <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                                    Commentaire (optionnel)
                                </label>
                                <textarea form="cuissonForm" name="commentaire" id="commentaire" rows="2"
                                          class="w-full rounded-md border-gray-300"
                                          placeholder="Informations complémentaires..."></textarea>
                            </div>

                            {{-- DLC + étiquettes + validation rapide --}}
                            <div class="space-y-3 pt-4 border-t">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label for="dlc_jours" class="block text-sm font-medium text-gray-700 mb-2">DLC (jours) *</label>
                                        <input type="number" name="dlc_jours" id="dlc_jours" min="1" value="3"
                                               form="cuissonForm"
                                               class="w-full rounded-md border-gray-300" required>
                                    </div>
                                    <div>
                                        <label for="nombre_etiquettes" class="block text-sm font-medium text-gray-700 mb-2">Étiquettes *</label>
                                        <input type="number" name="nombre_etiquettes" id="nombre_etiquettes" min="1" max="20" value="1"
                                               form="cuissonForm"
                                               class="w-full rounded-md border-gray-300" required>
                                    </div>
                                </div>
                                <button type="submit" form="cuissonForm"
                                        class="w-full px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                                    ✅ Valider et imprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sélection produit + infos cuisson --}}
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900">Choisissez le produit</h3>

                            <form method="POST" action="{{ route('cuisson-refroidissement.store') }}" id="cuissonForm" class="space-y-6">
                                @csrf
                                <input type="hidden" name="photo" value="{{ $photoData }}">
                                <input type="hidden" name="quantite" value="1">

                                {{-- Recherche produit --}}
                                <div>
                                    <input type="text"
                                           id="searchProduct"
                                           placeholder="Rechercher un produit..."
                                           class="w-full px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                </div>

                                {{-- Produits groupés par famille --}}
                                <div class="space-y-6 max-h-[550px] overflow-y-auto pr-2">
                                    @php
                                        $produitsParFamille = $produits->groupBy('famille');
                                    @endphp

                                    @foreach($produitsParFamille as $famille => $produitsGroupe)
                                        <div>
                                            <h4 class="text-md font-bold text-gray-800 mb-3 bg-orange-50 px-3 py-2 rounded">
                                                {{ $famille }}
                                            </h4>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 ml-2">
                                                @foreach($produitsGroupe as $produit)
                                                    <label class="relative cursor-pointer group produit-card" data-product-name="{{ strtolower($produit->nom) }}" data-dlc="{{ $produit->dlc_cuisson_defaut_jours ?? 3 }}">
                                                        <input type="radio"
                                                               name="produit_id"
                                                               value="{{ $produit->id }}"
                                                               class="peer sr-only"
                                                               required>
                                                        <div class="p-4 border-2 border-gray-300 rounded-lg hover:border-orange-500 peer-checked:border-green-600 peer-checked:bg-green-50 transition-all">
                                                            <div class="text-center">
                                                                <div class="text-3xl mb-2">🔥</div>
                                                                <div class="text-sm font-semibold text-gray-900">
                                                                    {{ $produit->nom }}
                                                                </div>
                                                                @if($produit->dlc_cuisson_defaut_jours)
                                                                    <div class="text-xs text-orange-600 mt-1">
                                                                        DLC par défaut: {{ $produit->dlc_cuisson_defaut_jours }} j
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchProduct');
            const cards = Array.from(document.querySelectorAll('.produit-card'));
            const dlcInput = document.getElementById('dlc_jours');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const term = this.value.toLowerCase().trim();
                    cards.forEach(card => {
                        const name = card.getAttribute('data-product-name');
                        card.style.display = name.includes(term) ? '' : 'none';
                    });
                });
            }

            cards.forEach(card => {
                card.addEventListener('click', () => {
                    const dlc = card.getAttribute('data-dlc');
                    if (dlc && dlcInput) {
                        dlcInput.value = dlc;
                    }
                });
            });
        });
    </script>
</x-app-layout>
