<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Éditer relevé température') }}
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

                    <form method="POST" action="{{ route('temperatures.update', $releve) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- Équipement --}}
                        <div>
                            <label for="equipement_temperature_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Équipement <span class="text-red-600">*</span>
                            </label>
                            <select name="equipement_temperature_id" id="equipement_temperature_id" required class="w-full rounded-md border-gray-300 @error('equipement_temperature_id') border-red-500 @enderror">
                                @foreach ($equipements as $eq)
                                    <option value="{{ $eq->id }}" {{ $releve->equipement_temperature_id == $eq->id ? 'selected' : '' }}>
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
                            <input type="number" name="temperature" id="temperature" step="0.1" value="{{ $releve->temperature }}" required class="w-full rounded-md border-gray-300 @error('temperature') border-red-500 @enderror">
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
                                    <input type="radio" name="conforme" value="1" {{ $releve->conforme ? 'checked' : '' }} class="rounded border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">✓ Oui (conforme)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="conforme" value="0" {{ !$releve->conforme ? 'checked' : '' }} class="rounded border-gray-300">
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
                                Action corrective
                            </label>
                            <textarea name="action_corrective" id="action_corrective" rows="3" class="w-full rounded-md border-gray-300">{{ $releve->action_corrective }}</textarea>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                                Mettre à jour
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
