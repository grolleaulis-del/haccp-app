@extends('layouts.app')

@section('content')
<div class="w-full px-2 py-4">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Nettoyage HACCP</h1>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-4 rounded mb-6 text-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Boutons d'action principaux -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
        <a href="{{ route('nettoyage.create') }}" class="bg-blue-500 text-white px-6 py-4 rounded text-lg font-bold text-center" style="background:#2563eb;color:#fff;">
            ➕ Enregistrer un nettoyage
        </a>
        <a href="{{ route('nettoyage.taches') }}" class="bg-gray-600 text-white px-6 py-4 rounded text-lg font-bold text-center" style="background:#4b5563;color:#fff;">
            ⚙️ Gérer les tâches
        </a>
    </div>

    <!-- Filtre par date -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <label class="text-gray-700 font-bold text-lg">Date :</label>
            <input type="date" name="date" value="{{ $date }}" class="border-2 border-gray-300 rounded px-4 py-2 text-lg flex-grow">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded text-lg font-bold" style="background:#2563eb;color:#fff;">Filtrer</button>
        </form>
    </div>

    <!-- État des tâches du jour -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">État des tâches - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h2>

        @if($taches->isEmpty())
            <p class="text-gray-600 text-lg">Aucune tâche active.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($taches as $tache)
                    @php
                        $completed = $tache->nettoyages->count() > 0;
                    @endphp
                    <div class="border-4 rounded-lg p-5 text-center {{ $completed ? 'border-green-500 bg-green-50' : 'border-gray-300 bg-gray-50' }}">
                        <div class="font-bold text-lg mb-3">{{ $tache->nom }}</div>
                        @if($completed)
                            <div class="text-green-600 font-bold text-2xl mb-3">✓ Complétée</div>
                            <form method="POST" action="{{ route('nettoyage.quick', $tache) }}">
                                @csrf
                                <button type="submit" class="w-full bg-gray-400 text-white px-4 py-3 rounded text-lg font-bold" style="background:#9ca3af;color:#fff;">
                                    Nouvelle validation
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('nettoyage.quick', $tache) }}">
                                @csrf
                                <button type="submit" class="w-full bg-green-500 text-white px-4 py-4 rounded text-xl font-bold" style="background:#22c55e;color:#fff;">
                                    ✓ VALIDER
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Historique du jour -->
    <div class="bg-white rounded-lg shadow-md p-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Historique du jour</h2>

        @if($historique->isEmpty())
            <p class="text-gray-600 text-lg">Aucun enregistrement pour cette date.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border-2 px-4 py-3 text-left font-bold text-lg">Heure</th>
                            <th class="border-2 px-4 py-3 text-left font-bold text-lg">Tâche</th>
                            <th class="border-2 px-4 py-3 text-left font-bold text-lg">Utilisateur</th>
                            <th class="border-2 px-4 py-3 text-left font-bold text-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historique as $record)
                            <tr class="hover:bg-gray-100">
                                <td class="border-2 px-4 py-3 text-lg">{{ $record->done_at->format('H:i') }}</td>
                                <td class="border-2 px-4 py-3 font-semibold text-lg">{{ $record->tache->nom }}</td>
                                <td class="border-2 px-4 py-3 text-lg">{{ $record->user->name }}</td>
                                <td class="border-2 px-4 py-3">
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('nettoyage.edit', $record) }}" class="bg-blue-500 text-white px-4 py-2 rounded text-center font-bold" style="background:#2563eb;color:#fff;">
                                            Éditer
                                        </a>
                                        <form action="{{ route('nettoyage.destroy', $record) }}" method="POST" onsubmit="return confirm('Supprimer ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 text-white px-4 py-2 rounded font-bold" style="background:#ef4444;color:#fff;">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $historique->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
