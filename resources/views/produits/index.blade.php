@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ selected: [], allSelected: false }">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-900">Paramètres Produits</h1>
        <div class="flex gap-2">
            <a href="{{ route('produits.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Nouveau
            </a>
            <a href="{{ route('produits.import') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 011.414 0L10 9.586l2.293-2.879a1 1 0 111.414 1.414l-3 3.75a1 1 0 01-1.414 0l-3-3.75a1 1 0 010-1.414z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M10 1a1 1 0 011 1v7h.5a.5.5 0 010 1H10h-.5a.5.5 0 010-1H10V2a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Import
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Filtres -->
    <div class="bg-white p-4 rounded-lg shadow mb-6 flex flex-col md:flex-row gap-4 justify-between items-center sticky top-0 z-20">
        <form method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto items-center">
            <select name="famille" class="border-gray-300 rounded-lg text-gray-700 h-10 w-full md:w-48" onchange="this.form.submit()">
                <option value="">Toutes les familles</option>
                @foreach($familles as $f)
                    <option value="{{ $f }}" {{ request('famille') == $f ? 'selected' : '' }}>{{ $f }}</option>
                @endforeach
            </select>
            <div class="relative w-full md:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." class="border-gray-300 rounded-lg h-10 px-4 w-full pr-10">
                <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>
        
        <!-- Actions de masse -->
        <div x-show="selected.length > 0" class="flex flex-wrap gap-2 bg-yellow-50 p-2 rounded border border-yellow-200 transition items-center" x-cloak>
            <span class="text-xs font-bold text-yellow-800 mr-2 whitespace-nowrap" x-text="selected.length + ' item(s)'"></span>
            
            <!-- Delete -->
            <form method="POST" action="{{ route('produits.destroy.multiple') }}" onsubmit="return confirm('Attention ! Supprimer ces produits est irréversible. Continuer ?');">
                @csrf
                <input type="hidden" name="selected" :value="JSON.stringify(selected)">
                <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200 border border-red-200 flex items-center gap-1">
                    🗑️ Suppr.
                </button>
            </form>
            
            <div class="h-4 w-px bg-yellow-300 mx-1"></div>

            <!-- Scan Toggle -->
            <form method="POST" action="{{ route('produits.toggle-visibility') }}">
                @csrf
                <input type="hidden" name="selected" :value="JSON.stringify(selected)">
                <input type="hidden" name="target" value="scan">
                <input type="hidden" name="action" value="show">
                <button type="submit" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200 border border-blue-200 mb-1" title="Afficher dans Scan">👁️ Scan</button>
            </form>
             <form method="POST" action="{{ route('produits.toggle-visibility') }}">
                @csrf
                <input type="hidden" name="selected" :value="JSON.stringify(selected)">
                <input type="hidden" name="target" value="scan">
                <input type="hidden" name="action" value="hide">
                <button type="submit" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200 border border-gray-200 mb-1" title="Masquer dans Scan">🚫 Scan</button>
            </form>

            <div class="h-4 w-px bg-yellow-300 mx-1"></div>

            <!-- Cuisson Toggle -->
             <form method="POST" action="{{ route('produits.toggle-visibility') }}">
                @csrf
                <input type="hidden" name="selected" :value="JSON.stringify(selected)">
                <input type="hidden" name="target" value="cuisson">
                <input type="hidden" name="action" value="show">
                <button type="submit" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200 border border-green-200 mb-1" title="Afficher dans Cuisson">👁️ Cuisson</button>
            </form>
             <form method="POST" action="{{ route('produits.toggle-visibility') }}">
                @csrf
                <input type="hidden" name="selected" :value="JSON.stringify(selected)">
                <input type="hidden" name="target" value="cuisson">
                <input type="hidden" name="action" value="hide">
                <button type="submit" class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200 border border-gray-200 mb-1" title="Masquer dans Cuisson">🚫 Cuisson</button>
            </form>
        </div>
    </div>

    <!-- Grille de Produits -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
        @foreach($produits as $produit)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition group relative border border-gray-100 flex flex-col h-full">
            <div class="absolute top-2 left-2 z-10 p-1 bg-white/80 rounded backdrop-blur-sm">
                <input type="checkbox" value="{{ $produit->id }}" x-model="selected" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300 shadow cursor-pointer">
            </div>
            
            <div class="h-32 md:h-40 bg-gray-100 flex items-center justify-center relative overflow-hidden group-hover:scale-105 transition duration-500">
                @if($produit->image_url)
                    <img src="{{ $produit->image_url }}" class="w-full h-full object-cover">
                @else
                    <span class="text-4xl text-gray-300 select-none">📦</span>
                @endif
            </div>

            <div class="p-3 md:p-4 flex flex-col flex-grow">
                <div class="flex justify-between items-start mb-1">
                    <span class="text-[10px] uppercase tracking-wider text-blue-600 truncate font-bold bg-blue-50 px-1 rounded">{{ $produit->famille }}</span>
                </div>
                <h3 class="font-bold text-sm md:text-lg text-gray-900 mb-1 leading-tight line-clamp-2" title="{{ $produit->nom }}">{{ $produit->nom }}</h3>
                
                <div class="flex-grow"></div>

                <!-- Indicateurs -->
                <div class="space-y-2 mt-3 pt-3 border-t border-gray-100">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500 flex items-center gap-1">🏷️ Scan</span>
                        <span class="px-2 py-0.5 rounded-full {{ $produit->visible_scan ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                            {{ $produit->visible_scan ? 'OUI' : 'NON' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500 flex items-center gap-1">🍳 Cuisson</span>
                         <span class="px-2 py-0.5 rounded-full {{ $produit->visible_cuisson ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                            {{ $produit->visible_cuisson ? 'OUI' : 'NON' }}
                        </span>
                    </div>
                    @if($produit->dlc_fournisseur)
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500 flex items-center gap-1">📅 DLC</span>
                        @php
                            $dlcDate = $produit->dlc_fournisseur;
                            $joursRestants = now()->diffInDays($dlcDate, false);
                        @endphp
                        <span class="px-2 py-0.5 rounded-full {{ $joursRestants <= 3 ? 'bg-red-100 text-red-700' : ($joursRestants <= 7 ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700') }}">
                            {{ $dlcDate->format('d/m/Y') }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-gray-50 p-2 border-t border-gray-100 flex justify-between gap-2">
                <a href="{{ route('produits.edit', $produit) }}" class="flex-1 text-center py-1 text-blue-600 hover:bg-blue-50 rounded text-xs font-medium transition">Éditer</a>
                <form action="{{ route('produits.destroy', $produit) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?');" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-1 text-red-500 hover:bg-red-50 rounded text-xs font-medium transition">Suppr.</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-6">
        {{ $produits->links() }}
    </div>
</div>
@endsection
