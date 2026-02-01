<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Éditer équipement') }}
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

                    <form method="POST" action="{{ route('equipements.update', $equipement) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom de l'équipement <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="nom" id="nom" value="{{ $equipement->nom }}" required class="w-full rounded-md border-gray-300 @error('nom') border-red-500 @enderror">
                            @error('nom')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="actif" value="1" {{ $equipement->actif ? 'checked' : '' }} class="rounded border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Actif</span>
                            </label>
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                                Mettre à jour
                            </button>
                            <a href="{{ route('equipements.index') }}" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-medium">
                                Annuler
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
