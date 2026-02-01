@extends('layouts.app')

@section('content')
<div class="w-full px-2 py-4">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Modifier une tâche</h1>

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
        <form action="{{ route('nettoyage.taches.update', $tache) }}" method="POST">
            @csrf
            @method('PATCH')

            <!-- Nom de la tâche -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold text-lg mb-3">Nom de la tâche <span class="text-red-500">*</span></label>
                <input type="text" name="nom" required maxlength="255"
                    value="{{ $tache->nom }}"
                    class="w-full border-2 border-gray-300 rounded px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('nom')
                    <p class="text-red-500 text-lg mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Statut -->
            <div class="mb-6">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="actif" value="1"
                        {{ ($tache->actif ?? false) ? 'checked' : '' }}
                        class="w-6 h-6 border-2 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <span class="text-gray-700 font-bold text-lg">Tâche active</span>
                </label>
                @error('actif')
                    <p class="text-red-500 text-lg mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full bg-blue-500 text-white px-6 py-4 rounded font-bold text-lg" style="background:#2563eb;color:#fff;">
                    ✓ Mettre à jour
                </button>
                <a href="{{ route('nettoyage.taches') }}" class="w-full bg-gray-500 text-white px-6 py-4 rounded font-bold text-lg text-center" style="background:#6b7280;color:#fff;">
        </form>
    </div>
</div>
@endsection
