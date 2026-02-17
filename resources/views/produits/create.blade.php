@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Nouveau Produit</h1>
        <a href="{{ route('produits.index') }}" class="text-gray-600 hover:text-gray-900">Retour</a>
    </div>

    {{-- Erreurs globales --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
            <p class="font-bold mb-1">Veuillez corriger les erreurs suivantes :</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">Nom du produit <span class="text-red-500">*</span></label>
                    <input type="text" name="nom" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nom') border-red-500 @enderror" required value="{{ old('nom') }}">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Famille / Catégorie <span class="text-red-500">*</span></label>
                    <input type="text" name="famille" list="familles" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('famille') border-red-500 @enderror" required value="{{ old('famille') }}" placeholder="Ex: Viandes, Poissons...">
                    <datalist id="familles">
                        @foreach($familles as $f)
                            <option value="{{ $f }}">
                        @endforeach
                    </datalist>
                    @error('famille')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Mode de Traçabilité</label>
                    <select name="mode_tracabilite" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="etiquette_photo" {{ old('mode_tracabilite') == 'etiquette_photo' ? 'selected' : '' }}>Photo de l'étiquette</option>
                        <option value="code_interne" {{ old('mode_tracabilite') == 'code_interne' ? 'selected' : '' }}>Code Interne / Numéro de Lot</option>
                    </select>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Image / Illustration</label>
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="text-sm text-gray-500"><span class="font-semibold">Cliquez pour ajouter</span> ou glissez une image</p>
                            <p class="text-xs text-gray-500">SVG, PNG, JPG (MAX. 2MB)</p>
                        </div>
                        <input id="dropzone-file" name="image" type="file" class="hidden" accept="image/*" />
                    </label>
                </div>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- DLC Defaults -->
            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                <h3 class="font-bold text-blue-800 mb-3 text-sm uppercase">Durées de conservation par défaut (Jours)</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm mb-1">Pour la Cuisson</label>
                        <input type="number" name="dlc_cuisson_defaut_jours" class="w-full border-gray-300 rounded-lg shadow-sm" value="{{ old('dlc_cuisson_defaut_jours') }}" placeholder="Ex: 3">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm mb-1">Pour la Congélation</label>
                        <input type="number" name="dlc_congelation_defaut_jours" class="w-full border-gray-300 rounded-lg shadow-sm" value="{{ old('dlc_congelation_defaut_jours') }}" placeholder="Ex: 90">
                    </div>
                </div>
            </div>

            <!-- DLC Fournisseur -->
            <div class="bg-orange-50 p-4 rounded-lg mb-6 border border-orange-200">
                <h3 class="font-bold text-orange-800 mb-3 text-sm uppercase flex items-center gap-2">
                    📅 DLC Fournisseur
                </h3>
                <p class="text-xs text-orange-600 mb-3">Date limite de consommation imprimée par le fournisseur (mayonnaise, beurre, etc.)</p>
                <input type="date" name="dlc_fournisseur" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500" value="{{ old('dlc_fournisseur') }}">
                @error('dlc_fournisseur')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Toggles Visibility -->
            <div class="mb-8 space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="flex flex-col">
                        <span class="font-bold text-gray-800">Actif</span>
                        <span class="text-xs text-gray-500">Le produit peut être utilisé dans l'application</span>
                    </span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="actif" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-4 ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <hr class="border-gray-200">
                 <div class="flex items-center justify-between">
                    <span class="flex flex-col">
                        <span class="font-bold text-gray-800">Module Scan Étiquette</span>
                        <span class="text-xs text-gray-500">Apparaît dans la liste des produits du scan</span>
                    </span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="visible_scan" value="1" class="sr-only peer" checked>
                         <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-4 ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                    </label>
                </div>
                <hr class="border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="flex flex-col">
                        <span class="font-bold text-gray-800">Module Cuisson</span>
                        <span class="text-xs text-gray-500">Apparaît dans la liste des produits en cuisson</span>
                    </span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="visible_cuisson" value="1" class="sr-only peer" checked>
                         <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-4 ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('produits.index') }}" class="px-6 py-2.5 text-gray-700 font-medium hover:bg-gray-100 rounded-lg transition">Annuler</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-bold shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-0.5">Enregistrer le produit</button>
            </div>
        </form>
    </div>
</div>
@endsection
