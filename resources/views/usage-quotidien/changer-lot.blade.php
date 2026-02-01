<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Changer le lot') }} - {{ $produit->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            {{-- Afficher les erreurs --}}
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

                    {{-- Infos du produit --}}
                    <div class="mb-6 p-4 bg-gray-50 rounded">
                        <h3 class="font-semibold text-gray-900 mb-2">{{ $produit->nom }}</h3>
                        <p class="text-sm text-gray-600">
                            <strong>Famille:</strong> {{ $produit->famille }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <strong>Mode traçabilité:</strong>
                            {{ $produit->mode_tracabilite === 'etiquette_photo' ? 'Photo étiquette' : 'Code interne' }}
                        </p>
                    </div>

                    {{-- Afficher le lot actif s'il existe --}}
                    @if ($lotActif)
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded">
                            <p class="text-sm text-blue-800 font-semibold mb-2">Lot actif actuel:</p>
                            <p class="text-sm text-blue-800">
                                Démarré le: {{ $lotActif->started_at->format('d/m/Y H:i') }}
                            </p>
                            @if ($lotActif->code_interne)
                                <p class="text-sm text-blue-800">
                                    Code: {{ $lotActif->code_interne }}
                                </p>
                            @endif
                            <p class="text-sm text-blue-800 italic mt-2">
                                (Ce lot sera clôturé et un nouveau créé)
                            </p>
                        </div>
                    @endif

                    {{-- Formulaire --}}
                    <form method="POST" action="{{ route('usage-quotidien.changer', $produit) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Photo (obligatoire si mode etiquette_photo) --}}
                        @if ($produit->mode_tracabilite === 'etiquette_photo')
                            <x-camera-capture
                                name="photo"
                                label="Photo étiquette"
                                :required="true" />
                            @error('photo')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        @else
                            {{-- Code interne (obligatoire si mode code_interne) --}}
                            <div>
                                <label for="code_interne" class="block text-sm font-medium text-gray-700 mb-2">
                                    Code interne <span class="text-red-600">*</span>
                                </label>
                                <input type="text"
                                       name="code_interne"
                                       id="code_interne"
                                       class="w-full rounded-md border-gray-300
                                              @error('code_interne') border-red-500 @enderror"
                                       required>
                                @error('code_interne')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Photo optionnelle --}}
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                    Photo (optionnelle)
                                </label>
                                <input type="file"
                                       name="photo"
                                       id="photo"
                                       accept="image/*"
                                       class="w-full rounded-md border-gray-300">
                                @error('photo')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Max 5 MB</p>
                            </div>
                        @endif

                        {{-- Commentaire --}}
                        <div>
                            <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                                Commentaire
                            </label>
                            <textarea name="commentaire"
                                      id="commentaire"
                                      rows="3"
                                      class="w-full rounded-md border-gray-300"></textarea>
                            @error('commentaire')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Boutons --}}
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium">
                                Créer le nouveau lot
                            </button>
                            <a href="{{ route('usage-quotidien.index') }}" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-medium">
                                Annuler
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
