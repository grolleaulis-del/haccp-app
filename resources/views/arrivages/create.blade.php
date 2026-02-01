<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvel arrivage') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Erreurs --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('arrivages.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Fournisseur --}}
                        <div>
                            <label for="fournisseur_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Fournisseur <span class="text-red-600">*</span>
                            </label>
                            <select name="fournisseur_id" id="fournisseur_id" required class="w-full rounded-md border-gray-300 @error('fournisseur_id') border-red-500 @enderror">
                                <option value="">-- Sélectionner --</option>
                                @foreach ($fournisseurs as $f)
                                    <option value="{{ $f->id }}" {{ old('fournisseur_id') == $f->id ? 'selected' : '' }}>
                                        {{ $f->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fournisseur_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Date --}}
                        <div>
                            <label for="date_arrivage" class="block text-sm font-medium text-gray-700 mb-2">
                                Date <span class="text-red-600">*</span>
                            </label>
                            <input type="date" name="date_arrivage" id="date_arrivage" value="{{ old('date_arrivage', now()->format('Y-m-d')) }}" required class="w-full rounded-md border-gray-300 @error('date_arrivage') border-red-500 @enderror">
                            @error('date_arrivage')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- BL --}}
                        <div>
                            <label for="bl_file" class="block text-sm font-medium text-gray-700 mb-2">
                                Bon de livraison (PDF/Image)
                            </label>
                            <input type="file" name="bl_file" id="bl_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full rounded-md border-gray-300">
                            <p class="text-xs text-gray-500 mt-1">Max 5 MB (PDF, JPG, PNG)</p>
                            @error('bl_file')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Commentaire --}}
                        <div>
                            <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                                Commentaire
                            </label>
                            <textarea name="commentaire" id="commentaire" rows="3" class="w-full rounded-md border-gray-300">{{ old('commentaire') }}</textarea>
                        </div>

                        {{-- Lignes --}}
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-4">Produits reçus</h3>
                            <div id="lignes-container" class="space-y-4">
                                <div class="ligne-item p-4 border border-gray-300 rounded">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Produit <span class="text-red-600">*</span>
                                            </label>
                                            <select name="lignes[0][produit_id]" required class="w-full rounded-md border-gray-300">
                                                <option value="">-- Sélectionner --</option>
                                                @foreach ($produits as $p)
                                                    <option value="{{ $p->id }}">{{ $p->nom }} ({{ $p->famille }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Numéro lot
                                            </label>
                                            <input type="text" name="lignes[0][numero_lot]" placeholder="ex: LOT123" class="w-full rounded-md border-gray-300">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Photo étiquette
                                            </label>
                                            <input type="file" name="lignes[0][photo]" accept="image/*" class="w-full rounded-md border-gray-300">
                                            <p class="text-xs text-gray-500 mt-1">Max 5 MB</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Commentaire
                                            </label>
                                            <input type="text" name="lignes[0][commentaire]" class="w-full rounded-md border-gray-300">
                                        </div>
                                    </div>
                                    <button type="button" class="mt-4 text-sm text-red-600 hover:text-red-700 remove-ligne">
                                        Supprimer cette ligne
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-ligne-btn" class="mt-4 text-sm text-blue-600 hover:text-blue-700">
                                + Ajouter une ligne
                            </button>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium">
                                Créer l'arrivage
                            </button>
                            <a href="{{ route('arrivages.index') }}" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-medium">
                                Annuler
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let ligneCount = 1;

            document.getElementById('add-ligne-btn').addEventListener('click', function() {
                const container = document.getElementById('lignes-container');
                const newLigne = document.querySelector('.ligne-item').cloneNode(true);

                // Update field names
                newLigne.querySelectorAll('[name]').forEach(input => {
                    input.name = input.name.replace(/\[0\]/g, '[' + ligneCount + ']');
                    input.value = '';
                });

                newLigne.querySelector('.remove-ligne').addEventListener('click', function() {
                    newLigne.remove();
                });

                container.appendChild(newLigne);
                ligneCount++;
            });

            document.querySelectorAll('.remove-ligne').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.ligne-item').remove();
                });
            });
        });
    </script>
</x-app-layout>
