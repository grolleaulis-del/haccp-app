<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Éditer arrivage') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

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

                    <form method="POST" action="{{ route('arrivages.update', $arrivage) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- Fournisseur --}}
                        <div>
                            <label for="fournisseur_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Fournisseur <span class="text-red-600">*</span>
                            </label>
                            <select name="fournisseur_id" id="fournisseur_id" required class="w-full rounded-md border-gray-300 @error('fournisseur_id') border-red-500 @enderror">
                                @foreach ($fournisseurs as $f)
                                    <option value="{{ $f->id }}" {{ $arrivage->fournisseur_id == $f->id ? 'selected' : '' }}>
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
                            <input type="date" name="date_arrivage" id="date_arrivage" value="{{ $arrivage->date_arrivage->format('Y-m-d') }}" required class="w-full rounded-md border-gray-300 @error('date_arrivage') border-red-500 @enderror">
                            @error('date_arrivage')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Commentaire --}}
                        <div>
                            <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                                Commentaire
                            </label>
                            <textarea name="commentaire" id="commentaire" rows="3" class="w-full rounded-md border-gray-300">{{ $arrivage->commentaire }}</textarea>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="px-6 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 font-medium">
                                Enregistrer
                            </button>
                            <a href="{{ route('arrivages.show', $arrivage) }}" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-medium">
                                Annuler
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
