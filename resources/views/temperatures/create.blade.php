<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter relevé température') }}
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

                    <form method="POST" action="{{ route('temperatures.store') }}" class="space-y-6">
                        @csrf

                        {{-- Équipement --}}
                        <div>
                            <label for="equipement_temperature_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Équipement <span class="text-red-600">*</span>
                            </label>
                            <select name="equipement_temperature_id" id="equipement_temperature_id" required class="w-full rounded-md border-gray-300 @error('equipement_temperature_id') border-red-500 @enderror">
                                <option value="">-- Sélectionner --</option>
                                @foreach ($equipements as $eq)
                                    <option value="{{ $eq->id }}" {{ old('equipement_temperature_id') == $eq->id ? 'selected' : '' }}>
                                        {{ $eq->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('equipement_temperature_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Température --}}
                        <div>
                            <label for="temperature" class="block text-sm font-medium text-gray-700 mb-2">
                                Température (°C) <span class="text-red-600">*</span>
                            </label>
                            <input type="number" name="temperature" id="temperature" step="0.1" value="{{ old('temperature') }}" required class="w-full rounded-md border-gray-300 @error('temperature') border-red-500 @enderror" placeholder="ex: 4.5">
                            @error('temperature')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Conformité --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Conforme aux normes <span class="text-red-600">*</span>
                            </label>
                            <div class="flex gap-6">
                                <label class="flex items-center">
                                    <input type="radio" name="conforme" value="1" {{ old('conforme') === '1' ? 'checked' : '' }} class="rounded border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">✓ Oui (conforme)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="conforme" value="0" {{ old('conforme') === '0' ? 'checked' : '' }} class="rounded border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">✗ Non (non conforme)</span>
                                </label>
                            </div>
                            @error('conforme')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Action corrective --}}
                        <div>
                            <label for="action_corrective" class="block text-sm font-medium text-gray-700 mb-2">
                                Action corrective (si non conforme)
                            </label>
                            <textarea name="action_corrective" id="action_corrective" rows="3" class="w-full rounded-md border-gray-300">{{ old('action_corrective') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Décrivez l'action prise pour corriger le problème</p>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium">
                                Enregistrer
                            </button>
                            <a href="{{ route('temperatures.index') }}" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 font-medium">
                                Annuler
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
