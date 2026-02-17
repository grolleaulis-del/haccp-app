<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le produit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('produits.update', $produit) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nom --}}
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">
                                Nom du produit <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom" id="nom" required
                                   value="{{ old('nom', $produit->nom) }}"
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
                                   value="{{ old('famille', $produit->famille) }}"
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

                        {{-- Image Upload --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image / Illustration</label>
                            <div class="flex items-center gap-4">
                                @if($produit->image_url)
                                    <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-200">
                                        <img src="{{ $produit->image_url }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="text-xs text-gray-500 mt-1">SVG, PNG, JPG (MAX. 2MB)</p>
                                </div>
                            </div>
                        </div>

                        {{-- Mode traçabilité --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Mode de traçabilité <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="mode_tracabilite" value="etiquette_photo"
                                           {{ old('mode_tracabilite', $produit->mode_tracabilite) === 'etiquette_photo' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2">Photo de l'étiquette</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="mode_tracabilite" value="code_interne"
                                           {{ old('mode_tracabilite', $produit->mode_tracabilite) === 'code_interne' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500">
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
                                    DLC Cuisson (jours)
                                </label>
                                <input type="number" name="dlc_cuisson_defaut_jours" id="dlc_cuisson_defaut_jours" min="1"
                                       value="{{ old('dlc_cuisson_defaut_jours', $produit->dlc_cuisson_defaut_jours) }}"
                                       class="w-full rounded-md border-gray-300 @error('dlc_cuisson_defaut_jours') border-red-500 @enderror">
                                @error('dlc_cuisson_defaut_jours')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- DLC Congélation --}}
                            <div>
                                <label for="dlc_congelation_defaut_jours" class="block text-sm font-medium text-gray-700 mb-1">
                                    DLC Congélation (jours)
                                </label>
                                <input type="number" name="dlc_congelation_defaut_jours" id="dlc_congelation_defaut_jours" min="1"
                                       value="{{ old('dlc_congelation_defaut_jours', $produit->dlc_congelation_defaut_jours) }}"
                                       class="w-full rounded-md border-gray-300 @error('dlc_congelation_defaut_jours') border-red-500 @enderror">
                                @error('dlc_congelation_defaut_jours')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- DLC Fournisseur --}}
                        <div class="mb-6 bg-orange-50 p-4 rounded-lg border border-orange-200">
                            <h3 class="font-bold text-orange-800 mb-2 text-sm uppercase flex items-center gap-2">
                                📅 DLC Fournisseur
                            </h3>
                            <p class="text-xs text-orange-600 mb-3">Date limite de consommation imprimée par le fournisseur (mayonnaise, beurre, etc.)</p>
                            <input type="date" name="dlc_fournisseur" id="dlc_fournisseur"
                                   value="{{ old('dlc_fournisseur', $produit->dlc_fournisseur ? $produit->dlc_fournisseur->format('Y-m-d') : '') }}"
                                   class="w-full rounded-md border-gray-300 focus:border-orange-500 focus:ring-orange-500 @error('dlc_fournisseur') border-red-500 @enderror">
                            @error('dlc_fournisseur')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Visibilité & Actif --}}
                        <div class="mb-8 space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="flex flex-col">
                                    <span class="font-bold text-gray-800">Actif</span>
                                    <span class="text-xs text-gray-500">Le produit peut être utilisé</span>
                                </span>
                                <label style="position:relative;display:inline-block;width:44px;height:24px;cursor:pointer;">
                                    <input type="checkbox" name="actif" value="1" {{ old('actif', $produit->actif) ? 'checked' : '' }}
                                           style="position:absolute;opacity:0;width:0;height:0;"
                                           onchange="this.parentElement.querySelector('span').style.background=this.checked?'#2563eb':'#d1d5db'; this.parentElement.querySelector('span span').style.transform=this.checked?'translateX(20px)':'translateX(0)'">
                                    <span style="position:absolute;inset:0;border-radius:12px;transition:0.3s;background:{{ old('actif', $produit->actif) ? '#2563eb' : '#d1d5db' }};">
                                        <span style="position:absolute;top:2px;left:2px;width:20px;height:20px;border-radius:50%;background:#fff;transition:0.3s;transform:{{ old('actif', $produit->actif) ? 'translateX(20px)' : 'translateX(0)' }};"></span>
                                    </span>
                                </label>
                            </div>
                            <hr class="border-gray-200">
                             <div class="flex items-center justify-between">
                                <span class="flex flex-col">
                                    <span class="font-bold text-gray-800">Module Scan Étiquette</span>
                                    <span class="text-xs text-gray-500">Visible dans Scan</span>
                                </span>
                                <label style="position:relative;display:inline-block;width:44px;height:24px;cursor:pointer;">
                                    <input type="checkbox" name="visible_scan" value="1" {{ old('visible_scan', $produit->visible_scan) ? 'checked' : '' }}
                                           style="position:absolute;opacity:0;width:0;height:0;"
                                           onchange="this.parentElement.querySelector('span').style.background=this.checked?'#16a34a':'#d1d5db'; this.parentElement.querySelector('span span').style.transform=this.checked?'translateX(20px)':'translateX(0)'">
                                    <span style="position:absolute;inset:0;border-radius:12px;transition:0.3s;background:{{ old('visible_scan', $produit->visible_scan) ? '#16a34a' : '#d1d5db' }};">
                                        <span style="position:absolute;top:2px;left:2px;width:20px;height:20px;border-radius:50%;background:#fff;transition:0.3s;transform:{{ old('visible_scan', $produit->visible_scan) ? 'translateX(20px)' : 'translateX(0)' }};"></span>
                                    </span>
                                </label>
                            </div>
                            <hr class="border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="flex flex-col">
                                    <span class="font-bold text-gray-800">Module Cuisson</span>
                                    <span class="text-xs text-gray-500">Visible dans Cuisson</span>
                                </span>
                                <label style="position:relative;display:inline-block;width:44px;height:24px;cursor:pointer;">
                                    <input type="checkbox" name="visible_cuisson" value="1" {{ old('visible_cuisson', $produit->visible_cuisson) ? 'checked' : '' }}
                                           style="position:absolute;opacity:0;width:0;height:0;"
                                           onchange="this.parentElement.querySelector('span').style.background=this.checked?'#16a34a':'#d1d5db'; this.parentElement.querySelector('span span').style.transform=this.checked?'translateX(20px)':'translateX(0)'">
                                    <span style="position:absolute;inset:0;border-radius:12px;transition:0.3s;background:{{ old('visible_cuisson', $produit->visible_cuisson) ? '#16a34a' : '#d1d5db' }};">
                                        <span style="position:absolute;top:2px;left:2px;width:20px;height:20px;border-radius:50%;background:#fff;transition:0.3s;transform:{{ old('visible_cuisson', $produit->visible_cuisson) ? 'translateX(20px)' : 'translateX(0)' }};"></span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('produits.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
