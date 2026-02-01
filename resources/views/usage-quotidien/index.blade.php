<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usage Quotidien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages flash --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Catégories de produits --}}
            @if (!$familleSelectionnee)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sélectionnez une catégorie</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($familles as $famille)
                                <a href="{{ route('usage-quotidien.index', ['famille' => $famille->famille]) }}"
                                   class="block p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-lg hover:from-blue-100 hover:to-blue-200 hover:border-blue-300 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900">{{ $famille->famille }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ $famille->count }} produit(s)</p>
                                        </div>
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Lots créés aujourd'hui --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Lots créés aujourd'hui ({{ $lotsAujourdhui->count() }})</h3>

                        @if($lotsAujourdhui->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Lot</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($lotsAujourdhui as $lot)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lot->started_at->format('H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $lot->produit->nom ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                            {{ $lot->numero_lot ?? $lot->code_interne ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($lot->photo_etiquette)
                                                <a href="{{ asset('storage/' . $lot->photo_etiquette) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $lot->photo_etiquette) }}"
                                                         alt="Photo"
                                                         class="h-16 w-16 object-cover rounded border-2 border-gray-300 hover:border-blue-500 transition cursor-pointer">
                                                </a>
                                            @elseif($lot->photo_path)
                                                <a href="{{ asset('storage/' . $lot->photo_path) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $lot->photo_path) }}"
                                                         alt="Photo"
                                                         class="h-16 w-16 object-cover rounded border-2 border-gray-300 hover:border-blue-500 transition cursor-pointer">
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lot->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            @if($lot->statut === 'actif')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                    ✓ Actif
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                                    Clôturé
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-4">Aucun lot créé aujourd'hui</p>
                        @endif
                    </div>
                </div>
            @else
                {{-- Retour aux catégories --}}
                <div class="mb-6">
                    <a href="{{ route('usage-quotidien.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Retour aux catégories
                    </a>
                </div>

                {{-- Titre de la catégorie --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $familleSelectionnee }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $produits->count() }} produit(s)</p>
                    </div>
                </div>

                {{-- Liste des produits --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        {{-- Barre de recherche --}}
                        <div class="mb-6">
                            <input type="text"
                                   id="searchProduct"
                                   placeholder="🔍 Rechercher un produit..."
                                   class="w-full px-4 py-3 text-lg border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div id="produitsContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                            @forelse ($produits as $produit)
                                <a href="{{ route('usage-quotidien.show-changer', $produit) }}"
                                   data-product-name="{{ strtolower($produit->nom) }}"
                                   class="produit-card relative block p-6 bg-white border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:shadow-lg transition-all duration-200 text-center group">

                                    {{-- Nom du produit --}}
                                    <div class="text-base font-semibold text-gray-900 group-hover:text-blue-600">
                                        {{ $produit->nom }}
                                    </div>

                                    {{-- Indicateur de statut de lot --}}
                                    @if ($produit->lotActif)
                                        <div class="mt-2 inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                            ✓ Lot actif
                                        </div>
                                    @else
                                        <div class="mt-2 inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                            ⚠️ Pas de lot
                                        </div>
                                    @endif
                                </a>
                            @empty
                                <div id="noResults" class="col-span-full text-center text-gray-500 py-8">
                                    Aucun produit trouvé dans cette catégorie.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Lots créés aujourd'hui (affiché aussi en bas) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Lots créés aujourd'hui ({{ $lotsAujourdhui->count() }})</h3>

                        @if($lotsAujourdhui->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Lot</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($lotsAujourdhui as $lot)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lot->started_at->format('H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $lot->produit->nom ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                            {{ $lot->numero_lot ?? $lot->code_interne ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($lot->photo_etiquette)
                                                <a href="{{ asset('storage/' . $lot->photo_etiquette) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $lot->photo_etiquette) }}"
                                                         alt="Photo"
                                                         class="h-16 w-16 object-cover rounded border-2 border-gray-300 hover:border-blue-500 transition cursor-pointer">
                                                </a>
                                            @elseif($lot->photo_path)
                                                <a href="{{ asset('storage/' . $lot->photo_path) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $lot->photo_path) }}"
                                                         alt="Photo"
                                                         class="h-16 w-16 object-cover rounded border-2 border-gray-300 hover:border-blue-500 transition cursor-pointer">
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $lot->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            @if($lot->statut === 'actif')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                    ✓ Actif
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                                    Clôturé
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-gray-500 text-center py-4">Aucun lot créé aujourd'hui</p>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>

    @if ($familleSelectionnee)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchProduct');
            const produitsContainer = document.getElementById('produitsContainer');
            const produitCards = document.querySelectorAll('.produit-card');
            const noResults = document.getElementById('noResults');

            // Auto-focus sur le champ de recherche
            searchInput.focus();

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                produitCards.forEach(function(card) {
                    const productName = card.getAttribute('data-product-name');

                    if (productName.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Afficher/masquer le message "Aucun résultat"
                if (visibleCount === 0 && searchTerm !== '') {
                    noResults.textContent = 'Aucun produit trouvé pour "' + searchTerm + '"';
                    noResults.style.display = 'block';
                } else if (visibleCount === 0) {
                    noResults.textContent = 'Aucun produit trouvé dans cette catégorie.';
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                }
            });
        });
    </script>
    @endif
</x-app-layout>
