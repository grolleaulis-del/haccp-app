<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🌡️ Relevé - {{ $equipement->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            {{-- Retour --}}
            <div class="mb-6">
                <a href="{{ route('temperatures.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour
                </a>
            </div>

            {{-- Formulaire simplifié --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $equipement->nom }}</h3>
                        @if ($equipement->temperature_min && $equipement->temperature_max)
                            <p class="text-lg text-gray-600">
                                Température attendue: {{ $equipement->temperature_min }}°C à {{ $equipement->temperature_max }}°C
                            </p>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('temperatures.quick.store', $equipement) }}" class="space-y-6">
                        @csrf

                        {{-- Température --}}
                        <div>
                            <label class="block text-xl font-semibold text-gray-700 mb-3">Température relevée</label>
                            <div class="flex items-center gap-4">
                                <input type="number"
                                       name="temperature"
                                       step="0.1"
                                       required
                                       autofocus
                                       class="flex-1 text-4xl text-center font-bold border-4 border-blue-300 rounded-xl py-6 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                       placeholder="0.0">
                                <span class="text-4xl font-bold text-gray-600">°C</span>
                            </div>
                            @error('temperature')
                                <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Conformité --}}
                        <div>
                            <label class="block text-xl font-semibold text-gray-700 mb-3">Conformité</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="conforme" value="1" required
                                           class="peer sr-only">
                                    <div class="p-6 border-4 border-gray-300 rounded-xl text-center transition-all
                                                peer-checked:border-green-500 peer-checked:bg-green-50">
                                        <div class="text-5xl mb-2">✓</div>
                                        <div class="text-xl font-bold text-gray-900">Conforme</div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="conforme" value="0" required
                                           class="peer sr-only">
                                    <div class="p-6 border-4 border-gray-300 rounded-xl text-center transition-all
                                                peer-checked:border-red-500 peer-checked:bg-red-50">
                                        <div class="text-5xl mb-2">✗</div>
                                        <div class="text-xl font-bold text-gray-900">Non conforme</div>
                                    </div>
                                </label>
                            </div>
                            @error('conforme')
                                <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Action corrective (affichée seulement si non conforme) --}}
                        <div x-data="{ showAction: false }">
                            <div x-show="showAction" style="display: none;">
                                <label class="block text-lg font-semibold text-gray-700 mb-2">Action corrective</label>
                                <textarea name="action_corrective" rows="3"
                                          class="w-full rounded-lg border-2 border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200"
                                          placeholder="Décrivez l'action corrective prise..."></textarea>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const radios = document.querySelectorAll('input[name="conforme"]');
                                    radios.forEach(radio => {
                                        radio.addEventListener('change', function() {
                                            Alpine.evaluate(document.querySelector('[x-data]'), 'showAction = ' + (this.value === '0'));
                                        });
                                    });
                                });
                            </script>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex gap-4 pt-4">
                            <a href="{{ route('temperatures.index') }}"
                               class="flex-1 px-6 py-4 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 font-bold text-center text-xl">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="flex-1 px-6 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-bold text-xl">
                                ✓ Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
