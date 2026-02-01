<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🔥 NOUVEAU FORMULAIRE - {{ $produit->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Infos du produit --}}
                    <div class="mb-6 p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg border-2 border-orange-300">
                        <h3 class="font-semibold text-gray-900 mb-2 text-xl">{{ $produit->nom }}</h3>
                        <p class="text-sm text-gray-700">
                            <strong>Famille:</strong> {{ $produit->famille }}
                        </p>
                        @if($produit->dlc_cuisson_defaut_jours)
                            <p class="text-sm text-orange-700 font-semibold mt-1">
                                📅 DLC par défaut: {{ $produit->dlc_cuisson_defaut_jours }} jours
                            </p>
                        @endif
                    </div>

                    {{-- Formulaire --}}
                    <form method="POST" action="{{ route('cuisson-refroidissement.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                        {{-- Photo de l'étiquette --}}
                        <x-camera-capture
                            name="photo"
                            label="📸 Photo de l'étiquette"
                            :required="true" />

                        {{-- DLC --}}
                        <div>
                            <label for="dlc_jours" class="block text-lg font-bold text-gray-900 mb-2">
                                📅 DLC (nombre de jours) <span class="text-red-600">*</span>
                            </label>
                            <input type="number"
                                   name="dlc_jours"
                                   id="dlc_jours"
                                   min="1"
                                   value="{{ old('dlc_jours', $produit->dlc_cuisson_defaut_jours ?? 3) }}"
                                   required
                                   class="w-full text-3xl p-6 border-4 border-orange-300 rounded-xl focus:border-orange-500 focus:ring focus:ring-orange-200 font-bold text-center">
                            <p class="text-sm text-gray-600 mt-2 text-center">Modifiez si nécessaire</p>
                        </div>

                        {{-- Nombre d'étiquettes --}}
                        <div>
                            <label for="nombre_etiquettes" class="block text-lg font-bold text-gray-900 mb-2">
                                🏷️ Nombre d'étiquettes à imprimer <span class="text-red-600">*</span>
                            </label>
                            <input type="number"
                                   name="nombre_etiquettes"
                                   id="nombre_etiquettes"
                                   min="1"
                                   max="20"
                                   value="{{ old('nombre_etiquettes', 1) }}"
                                   required
                                   class="w-full text-3xl p-6 border-4 border-blue-300 rounded-xl focus:border-blue-500 focus:ring focus:ring-blue-200 font-bold text-center">
                            <p class="text-sm text-gray-600 mt-2 text-center">Nombre de contenants</p>
                        </div>

                        {{-- Quantité cachée --}}
                        <input type="hidden" name="quantite" value="1">

                        {{-- Boutons --}}
                        <div class="flex gap-4 pt-4">
                            <a href="{{ route('cuisson-refroidissement.index') }}"
                               class="flex-1 py-6 bg-gray-600 text-white text-xl font-bold rounded-xl hover:bg-gray-700 text-center">
                                ← Annuler
                            </a>
                            <button type="submit"
                                    class="flex-1 py-6 bg-green-600 text-white text-xl font-bold rounded-xl hover:bg-green-700">
                                ✓ Valider et imprimer
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
<!-- v:1769258988 -->
</x-app-layout>
