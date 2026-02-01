<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Paramètres') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">⚙️ Configuration du système</h3>
                        {{-- Bouton invisible vers boîte noire --}}
                        <a href="{{ route('activity-logs.index') }}"
                           class="opacity-0 hover:opacity-100 transition-opacity duration-300 text-lg text-gray-600 hover:text-gray-800"
                           title="Boîte noire">
                            🕵️
                        </a>
                    </div>

                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Configuration imprimante --}}
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">🖨️ Imprimante à étiquettes</h4>

                            <div class="space-y-4">
                                <div>
                                    <label for="printer_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nom de l'imprimante
                                    </label>
                                    <input type="text" name="printer_name" id="printer_name"
                                           value="{{ old('printer_name', $printer_name) }}"
                                           class="w-full rounded-md border-gray-300"
                                           placeholder="Ex: Zebra ZD410, Brother QL-800...">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Nom de l'imprimante tel qu'il apparaît dans votre système
                                    </p>
                                </div>

                                <div>
                                    <label for="printer_type" class="block text-sm font-medium text-gray-700 mb-1">
                                        Type d'imprimante
                                    </label>
                                    <select name="printer_type" id="printer_type"
                                            class="w-full rounded-md border-gray-300">
                                        <option value="zebra" {{ $printer_type === 'zebra' ? 'selected' : '' }}>
                                            Zebra (ZPL)
                                        </option>
                                        <option value="brother" {{ $printer_type === 'brother' ? 'selected' : '' }}>
                                            Brother (P-Touch)
                                        </option>
                                        <option value="dymo" {{ $printer_type === 'dymo' ? 'selected' : '' }}>
                                            Dymo
                                        </option>
                                        <option value="generic" {{ $printer_type === 'generic' ? 'selected' : '' }}>
                                            Générique (PDF)
                                        </option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="label_width" class="block text-sm font-medium text-gray-700 mb-1">
                                            Largeur étiquette (mm)
                                        </label>
                                        <input type="number" name="label_width" id="label_width"
                                               value="{{ old('label_width', $label_width) }}"
                                               class="w-full rounded-md border-gray-300"
                                               min="10" max="500" step="1">
                                    </div>

                                    <div>
                                        <label for="label_height" class="block text-sm font-medium text-gray-700 mb-1">
                                            Hauteur étiquette (mm)
                                        </label>
                                        <input type="number" name="label_height" id="label_height"
                                               value="{{ old('label_height', $label_height) }}"
                                               class="w-full rounded-md border-gray-300"
                                               min="10" max="500" step="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Configuration caméra --}}
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">📸 Configuration photo</h4>

                            <div class="space-y-3">
                                <div class="flex items-center p-3 bg-blue-50 border border-blue-200 rounded">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <strong>Sur mobile :</strong> L'appareil photo sera utilisé automatiquement
                                    </div>
                                </div>
                                <div class="flex items-center p-3 bg-blue-50 border border-blue-200 rounded">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <strong>Sur ordinateur :</strong> La webcam sera utilisée
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Configuration de la session --}}
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">⏱️ Gestion de la session</h4>

                            <div>
                                <label for="inactivity_timeout" class="block text-sm font-medium text-gray-700 mb-1">
                                    Délai d'inactivité (minutes)
                                </label>
                                <input type="number" name="inactivity_timeout" id="inactivity_timeout"
                                       value="{{ old('inactivity_timeout', $inactivity_timeout) }}"
                                       class="w-full rounded-md border-gray-300"
                                       min="1" max="60" step="1" required>
                                <p class="mt-1 text-xs text-gray-500">
                                    Temps d'inactivité avant retour automatique à l'écran de sélection employé (1 à 60 minutes)
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('dashboard') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                💾 Enregistrer les paramètres
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
