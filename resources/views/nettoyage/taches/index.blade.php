@extends('layouts.app')

@section('content')
<div class="w-full px-2 py-4">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Gérer les tâches</h1>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-4 rounded mb-6 text-lg">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('nettoyage.taches.create') }}" class="inline-block w-full mb-6 bg-green-500 text-white px-6 py-4 rounded text-lg font-bold text-center" style="background:#22c55e;color:#fff;">
        ➕ Nouvelle tâche
    </a>

    <div class="bg-white rounded-lg shadow-md p-4">
        @if($taches->isEmpty())
            <p class="text-gray-600 text-lg">Aucune tâche créée.</p>
        @else
            <div class="space-y-3">
                @foreach($taches as $tache)
                    <div class="border-2 border-gray-300 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $tache->nom }}</h3>
                                <div class="mt-2">
                                    @if($tache->actif)
                                        <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full font-bold" style="background:#dcfce7;color:#166534;">
                                            ✓ Actif
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-bold" style="background:#f3f4f6;color:#374151;">
                                            Inactif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('nettoyage.taches.edit', $tache) }}" class="w-full bg-blue-500 text-white px-4 py-3 rounded text-lg font-bold text-center" style="background:#2563eb;color:#fff;">
                                Éditer
                            </a>
                            <form action="{{ route('nettoyage.taches.destroy', $tache) }}" method="POST" onsubmit="return confirm('Supprimer cette tâche ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-500 text-white px-4 py-3 rounded text-lg font-bold" style="background:#ef4444;color:#fff;">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('nettoyage.index') }}" class="inline-block bg-gray-600 text-white px-6 py-3 rounded text-lg font-bold" style="background:#4b5563;color:#fff;">
            ← Retour au nettoyage
        </a>
    </div>
</div>
@endsection
