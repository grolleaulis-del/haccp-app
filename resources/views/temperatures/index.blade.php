<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🌡️ Relevé de Températures
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages flash --}}
            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Grille des équipements --}}
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sélectionnez un équipement</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($equipements as $equipement)
                        @php
                            $lastReleve = $equipement->releves->first();
                            $isConforme = $lastReleve ? $lastReleve->conforme : null;
                        @endphp
                        <a href="{{ route('temperatures.quick', $equipement) }}"
                           class="relative block p-6 rounded-xl border-2 transition-all duration-200 hover:scale-105 hover:shadow-lg
                                  {{ $isConforme === true ? 'bg-green-50 border-green-300 hover:border-green-500' :
                                     ($isConforme === false ? 'bg-red-50 border-red-300 hover:border-red-500' :
                                     'bg-gray-50 border-gray-300 hover:border-blue-500') }}">

                            {{-- Nom de l'équipement --}}
                            <div class="text-center mb-3">
                                <h4 class="font-bold text-lg text-gray-900">{{ $equipement->nom }}</h4>
                            </div>

                            {{-- Dernier relevé --}}
                            @if ($lastReleve)
                                <div class="text-center">
                                    <div class="text-3xl font-bold {{ $isConforme ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $lastReleve->temperature }}°C
                                    </div>
                                    <div class="text-xs text-gray-600 mt-1">
                                        {{ $lastReleve->created_at->format('H:i') }}
                                    </div>
                                    <div class="mt-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                               {{ $isConforme ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $isConforme ? '✓ Conforme' : '✗ Non conforme' }}
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-gray-500 text-sm italic">
                                    Aucun relevé
                                </div>
                            @endif

                            {{-- Plage de température --}}
                            @if ($equipement->temperature_min && $equipement->temperature_max)
                                <div class="mt-3 text-center text-xs text-gray-600">
                                    Plage: {{ $equipement->temperature_min }}°C à {{ $equipement->temperature_max }}°C
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Lien vers historique complet --}}
            <div class="text-center">
                <a href="{{ route('temperatures.historique') }}"
                   class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-medium">
                    📊 Voir l'historique complet
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
