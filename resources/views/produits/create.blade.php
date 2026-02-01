<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer un nouveau produit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('produits.store') }}">
                        @csrf

                        {{-- Nom --}}
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">
                                Nom du produit <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom" id="nom" required
                                   value="{{ old('nom') }}"
                                   class="w-full rounded-md border-gray-300 @error('nom') border-red-500 @enderror">
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Famille --}}
                        <div class="mb-4">
                            <label for="famille" class="block text-sm font-medium text-gray-700 mb-1">
                                Catégorie <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="famille" id="famille" list="familles" required
                                   value="{{ old('famille') }}"
                                   class="w-full rounded-md border-gray-300 @error('famille') border-red-500 @enderror"
                                   placeholder="Saisissez une nouvelle catégorie ou choisissez existante">
                            <datalist id="familles">
                                @foreach ($familles as $famille)
                                    <option value="{{ $famille }}">
                                @endforeach
                            </datalist>
                            <p class="mt-1 text-sm text-gray-500">Vous pouvez saisir une nouvelle catégorie ou en choisir une existante</p>
                            @error('famille')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Mode traçabilité --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Mode de traçabilité <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="mode_tracabilite" value="etiquette_photo"
                                           {{ old('mode_tracabilite', 'etiquette_photo') === 'etiquette_photo' ? 'checked' : '' }}
                                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2">Photo de l'étiquette</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="mode_tracabilite" value="code_interne"
                                           {{ old('mode_tracabilite') === 'code_interne' ? 'checked' : '' }}
                                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2">Code interne</span>
                                </label>
                            </div>
                            @error('mode_tracabilite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            {{-- DLC Cuisson --}}
                            <div>
                                <label for="dlc_cuisson_defaut_jours" class="block text-sm font-medium text-gray-700 mb-1">
                                    DLC Cuisson par défaut (jours)
                                </label>
                                <input type="number" name="dlc_cuisson_defaut_jours" id="dlc_cuisson_defaut_jours" min="1"
                                       value="{{ old('dlc_cuisson_defaut_jours') }}"
                                       class="w-full rounded-md border-gray-300 @error('dlc_cuisson_defaut_jours') border-red-500 @enderror">
                                @error('dlc_cuisson_defaut_jours')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- DLC Congélation --}}
                            <div>
                                <label for="dlc_congelation_defaut_jours" class="block text-sm font-medium text-gray-700 mb-1">
                                    DLC Congélation par défaut (jours)
                                </label>
                                <input type="number" name="dlc_congelation_defaut_jours" id="dlc_congelation_defaut_jours" min="1"
                                       value="{{ old('dlc_congelation_defaut_jours') }}"
                                       class="w-full rounded-md border-gray-300 @error('dlc_congelation_defaut_jours') border-red-500 @enderror">
                                @error('dlc_congelation_defaut_jours')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Actif --}}
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="actif" value="1"
                                       {{ old('actif', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Produit actif</span>
                            </label>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('produits.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Créer le produit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
