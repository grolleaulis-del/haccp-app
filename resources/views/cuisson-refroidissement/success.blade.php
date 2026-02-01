<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✅ Cuisson enregistrée
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <div class="text-6xl mb-6">✅</div>
                <h3 class="text-3xl font-bold text-green-600 mb-4">Cuisson enregistrée avec succès !</h3>

                <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                    <h4 class="font-bold text-gray-900 mb-4 text-xl">Détails de la cuisson</h4>
                    <div class="space-y-2">
                        <p><span class="font-semibold">Produit:</span> {{ $lot->produit->nom }}</p>
                        <p><span class="font-semibold">Quantité:</span> {{ $lot->quantite }}</p>
                        <p><span class="font-semibold">Date de production:</span> {{ $lot->date_production->format('d/m/Y H:i') }}</p>
                        <p><span class="font-semibold">DLC:</span> {{ $lot->dlc->format('d/m/Y') }}</p>
                        @if($lot->temperature_cuisson)
                            <p><span class="font-semibold">Température cuisson:</span> {{ $lot->temperature_cuisson }}°C</p>
                        @endif
                        @if($lot->temperature_refroidissement)
                            <p><span class="font-semibold">Température refroidissement:</span> {{ $lot->temperature_refroidissement }}°C</p>
                        @endif
                    </div>
                </div>

                @if($lot->photo_etiquette)
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $lot->photo_etiquette) }}"
                             alt="Photo étiquette"
                             class="max-w-full h-auto rounded-lg border-4 border-gray-300 mx-auto">
                    </div>
                @endif

                {{-- Impression d'étiquettes --}}
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h4 class="font-bold text-gray-900 mb-4 text-lg">🏷️ Imprimer des étiquettes</h4>
                    <form action="{{ route('cuisson-refroidissement.print-labels', $lot) }}" method="POST" target="_blank" class="flex gap-4 items-end">
                        @csrf
                        <div class="flex-1 text-left">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre d'étiquettes</label>
                            <input type="number" name="nombre_etiquettes" value="1" min="1" max="20"
                                   class="w-full rounded-md border-gray-300 text-lg py-3">
                        </div>
                        <button type="submit" class="px-8 py-3 bg-blue-600 text-white text-lg font-bold rounded-lg hover:bg-blue-700">
                            🖨️ Imprimer
                        </button>
                    </form>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('cuisson-refroidissement.index') }}"
                       class="flex-1 py-4 bg-orange-600 text-white text-lg font-bold rounded-xl hover:bg-orange-700">
                        🔥 Nouvelle cuisson
                    </a>
                    <a href="{{ route('dashboard') }}"
                       class="flex-1 py-4 bg-gray-600 text-white text-lg font-bold rounded-xl hover:bg-gray-700">
                        🏠 Retour au dashboard
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
