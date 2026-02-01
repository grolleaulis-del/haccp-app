@extends('layouts.app')

@section('content')
<div class="w-full px-2 py-4">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Modifier un nettoyage</h1>

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-4 rounded mb-6 text-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-4">
        <form action="{{ route('nettoyage.update', $nettoyage) }}" method="POST">
            @csrf
            @method('PATCH')

            <!-- Sélection de la tâche -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold text-lg mb-3">Tâche de nettoyage <span class="text-red-500">*</span></label>
                <select name="tache_nettoyage_id" required class="w-full border-2 border-gray-300 rounded px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Sélectionner une tâche --</option>
                    @foreach($taches as $tache)
                        <option value="{{ $tache->id }}" {{ $nettoyage->tache_nettoyage_id == $tache->id ? 'selected' : '' }}>
                            {{ $tache->nom }}
                        </option>
                    @endforeach
                </select>
                @error('tache_nettoyage_id')
                    <p class="text-red-500 text-lg mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date et heure -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold text-lg mb-3">Date et heure <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="done_at" required
                    value="{{ $nettoyage->done_at->format('Y-m-d\TH:i') }}"
                    class="w-full border-2 border-gray-300 rounded px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('done_at')
                    <p class="text-red-500 text-lg mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Commentaire -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold text-lg mb-3">Commentaire (optionnel)</label>
                <textarea name="commentaire" rows="4" class="w-full border-2 border-gray-300 rounded px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $nettoyage->commentaire }}</textarea>
                @error('commentaire')
                    <p class="text-red-500 text-lg mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Informations -->
            <div class="mb-6 bg-gray-100 p-4 rounded text-lg text-gray-700">
                <p><strong>Créé par :</strong> {{ $nettoyage->user->name ?? 'N/A' }} le {{ $nettoyage->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Boutons -->
            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full bg-blue-500 text-white px-6 py-4 rounded font-bold text-lg" style="background:#2563eb;color:#fff;">
                    ✓ Mettre à jour
                </button>
                <a href="{{ route('nettoyage.index') }}" class="w-full bg-gray-500 text-white px-6 py-4 rounded font-bold text-lg text-center" style="background:#6b7280;color:#fff;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
