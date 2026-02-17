@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6" x-data="produitManager()">

    <!-- En-tête -->
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-gray-800">📦 Produits</h1>
        <a href="{{ route('settings.index') }}" class="px-3 py-2 rounded-lg font-bold text-sm" style="background:#e5e7eb;color:#374151;">
            ← Retour
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-xl text-sm font-medium" style="background:#dcfce7;color:#166534;">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 rounded-xl text-sm font-medium" style="background:#fee2e2;color:#991b1b;">
            ❌ {{ session('error') }}
        </div>
    @endif

    <!-- Actions rapides -->
    <div class="flex gap-2 mb-4 flex-wrap">
        <a href="{{ route('produits.create') }}" class="px-4 py-2 rounded-xl font-bold text-sm text-white" style="background:#3b82f6;">
            ➕ Nouveau
        </a>
        <a href="{{ route('produits.import') }}" class="px-4 py-2 rounded-xl font-bold text-sm" style="background:#f3e8ff;color:#7c3aed;">
            📥 Importer
        </a>
        <a href="{{ route('produits.template') }}" class="px-4 py-2 rounded-xl font-bold text-sm" style="background:#e0e7ff;color:#3730a3;">
            📄 Modèle CSV
        </a>
        <a href="{{ route('familles.index') }}" class="px-4 py-2 rounded-xl font-bold text-sm" style="background:#fef3c7;color:#92400e;">
            🏷️ Familles
        </a>
    </div>

    <!-- Recherche -->
    <div class="mb-4">
        <input type="text" x-model="search" placeholder="🔍 Rechercher un produit..."
               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
               style="background:#f9fafb;">
    </div>

    <!-- Filtres famille -->
    <div class="flex gap-2 overflow-x-auto pb-2 mb-4 -mx-4 px-4" style="-webkit-overflow-scrolling:touch;">
        <button @click="familleFilter = ''" class="px-3 py-2 rounded-full text-sm font-bold whitespace-nowrap transition"
                :style="familleFilter === '' ? 'background:#1f2937;color:#fff' : 'background:#f3f4f6;color:#374151'">
            Tous ({{ $produits->count() }})
        </button>
        @foreach($familles as $f)
            <button @click="familleFilter = '{{ $f }}'" class="px-3 py-2 rounded-full text-sm font-bold whitespace-nowrap transition"
                    :style="familleFilter === '{{ $f }}' ? 'background:#1f2937;color:#fff' : 'background:#f3f4f6;color:#374151'">
                {{ $familleEmojis[$f] ?? '🐟' }} {{ $f }} ({{ $produits->where('famille', $f)->count() }})
            </button>
        @endforeach
    </div>

    <!-- Filtres attributs -->
    <div class="flex gap-2 overflow-x-auto pb-2 mb-4 -mx-4 px-4" style="-webkit-overflow-scrolling:touch;">
        <button @click="attrFilter = attrFilter === 'scan' ? '' : 'scan'" class="px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition"
                :style="attrFilter === 'scan' ? 'background:#1d4ed8;color:#fff' : 'background:#dbeafe;color:#1d4ed8'">
            📷 Scan
        </button>
        <button @click="attrFilter = attrFilter === 'cuisson' ? '' : 'cuisson'" class="px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition"
                :style="attrFilter === 'cuisson' ? 'background:#92400e;color:#fff' : 'background:#fef3c7;color:#92400e'">
            🔥 Cuisson
        </button>
        <button @click="attrFilter = attrFilter === 'inactif' ? '' : 'inactif'" class="px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition"
                :style="attrFilter === 'inactif' ? 'background:#991b1b;color:#fff' : 'background:#fee2e2;color:#991b1b'">
            🚫 Inactifs
        </button>
        <button @click="attrFilter = attrFilter === 'dlc' ? '' : 'dlc'" class="px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition"
                :style="attrFilter === 'dlc' ? 'background:#374151;color:#fff' : 'background:#f3f4f6;color:#374151'">
            📅 DLC
        </button>
        <button @click="attrFilter = attrFilter === 'dlc_fourn' ? '' : 'dlc_fourn'" class="px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition"
                :style="attrFilter === 'dlc_fourn' ? 'background:#ea580c;color:#fff' : 'background:#fff7ed;color:#ea580c'">
            📅 DLC Fourn.
        </button>
        <button @click="attrFilter = attrFilter === 'no_scan' ? '' : 'no_scan'" class="px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition"
                :style="attrFilter === 'no_scan' ? 'background:#6b7280;color:#fff' : 'background:#f3f4f6;color:#6b7280'">
            📷❌ Sans Scan
        </button>
        <button @click="attrFilter = attrFilter === 'no_cuisson' ? '' : 'no_cuisson'" class="px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition"
                :style="attrFilter === 'no_cuisson' ? 'background:#6b7280;color:#fff' : 'background:#f3f4f6;color:#6b7280'">
            🔥❌ Sans Cuisson
        </button>
    </div>

    <!-- Barre selection -->
    <div x-show="selectedIds.length > 0" x-transition
         class="sticky top-0 z-20 mb-4 p-3 rounded-xl shadow-lg flex items-center gap-2 flex-wrap" style="background:#1f2937;">
        <span class="text-white text-sm font-bold" x-text="selectedIds.length + ' sélectionné(s)'"></span>
        <div class="flex gap-2 flex-wrap flex-1 justify-end">
            <button @click="bulkAction('toggle_scan')" class="px-3 py-1.5 rounded-lg text-xs font-bold" style="background:#dbeafe;color:#1d4ed8;">
                📷 Scan
            </button>
            <button @click="bulkAction('toggle_cuisson')" class="px-3 py-1.5 rounded-lg text-xs font-bold" style="background:#fef3c7;color:#92400e;">
                🔥 Cuisson
            </button>
            <button @click="bulkAction('toggle_actif')" class="px-3 py-1.5 rounded-lg text-xs font-bold" style="background:#dcfce7;color:#166534;">
                ✅ Actif
            </button>
            <button @click="bulkAction('delete')" class="px-3 py-1.5 rounded-lg text-xs font-bold" style="background:#fee2e2;color:#991b1b;">
                🗑️ Suppr
            </button>
        </div>
    </div>

    <!-- Select All -->
    <div class="flex items-center gap-2 mb-3 px-1">
        <input type="checkbox" @click="toggleAll()" :checked="allSelected" class="w-5 h-5 rounded" id="selectAll">
        <label for="selectAll" class="text-sm text-gray-500 font-medium">Tout sélectionner</label>
    </div>

    <!-- Cartes produits -->
    <div class="space-y-2">
        @foreach($produits as $produit)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 flex items-center gap-3 transition"
                 x-show="(familleFilter === '' || familleFilter === '{{ $produit->famille }}') && matchesAttr({{ json_encode(['scan' => $produit->visible_scan, 'cuisson' => $produit->visible_cuisson, 'actif' => $produit->actif, 'dlc' => $produit->dlc_cuisson_defaut_jours, 'dlc_fourn' => $produit->dlc_fournisseur ? true : false]) }}) && matchesSearch('{{ addslashes($produit->nom) }}', '{{ addslashes($produit->famille) }}')"
                 :class="selectedIds.includes({{ $produit->id }}) ? 'ring-2 ring-blue-500' : ''"
                 style="{{ !$produit->actif ? 'opacity:0.5;' : '' }}">
                
                <!-- Checkbox -->
                <input type="checkbox" :value="{{ $produit->id }}" 
                       @change="toggleSelect({{ $produit->id }})"
                       :checked="selectedIds.includes({{ $produit->id }})"
                       class="w-5 h-5 rounded flex-shrink-0">

                <!-- Emoji illustration -->
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                     style="background:#f9fafb;">
                    {{ $familleEmojis[$produit->famille] ?? '🐟' }}
                </div>

                <!-- Infos -->
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-gray-800 text-sm truncate">{{ $produit->nom }}</div>
                    <div class="text-xs text-gray-400">{{ $produit->famille }}</div>
                    <div class="flex gap-1 mt-1 flex-wrap">
                        @if($produit->visible_scan)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background:#dbeafe;color:#1d4ed8;">📷 Scan</span>
                        @endif
                        @if($produit->visible_cuisson)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background:#fef3c7;color:#92400e;">🔥 Cuisson</span>
                        @endif
                        @if(!$produit->actif)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background:#fee2e2;color:#991b1b;">INACTIF</span>
                        @endif
                        @if($produit->dlc_cuisson_defaut_jours)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="background:#f3f4f6;color:#374151;">DLC {{ $produit->dlc_cuisson_defaut_jours }}j</span>
                        @endif
                        @if($produit->dlc_fournisseur)
                            @php
                                $joursRestants = now()->diffInDays($produit->dlc_fournisseur, false);
                                $dlcColor = $joursRestants <= 3 ? 'background:#fee2e2;color:#991b1b' : ($joursRestants <= 7 ? 'background:#fff7ed;color:#ea580c' : 'background:#dcfce7;color:#166534');
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold" style="{{ $dlcColor }}">
                                📅 {{ $produit->dlc_fournisseur->format('d/m') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <a href="{{ route('produits.edit', $produit) }}" class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0" style="background:#f3f4f6;">
                    ✏️
                </a>
            </div>
        @endforeach
    </div>

    <!-- Compteur -->
    <div class="mt-4 text-center text-sm text-gray-400">
        {{ $produits->count() }} produit(s) au total
    </div>
</div>

<script>
function produitManager() {
    return {
        selectedIds: [],
        familleFilter: '',
        attrFilter: '',
        search: '',
        matchesSearch(nom, famille) {
            if (this.search === '') return true;
            const q = this.search.toLowerCase();
            return nom.toLowerCase().includes(q) || famille.toLowerCase().includes(q);
        },
        matchesAttr(p) {
            if (this.attrFilter === '') return true;
            if (this.attrFilter === 'scan') return p.scan == 1;
            if (this.attrFilter === 'cuisson') return p.cuisson == 1;
            if (this.attrFilter === 'inactif') return p.actif == 0;
            if (this.attrFilter === 'dlc') return p.dlc > 0;
            if (this.attrFilter === 'dlc_fourn') return p.dlc_fourn == true;
            if (this.attrFilter === 'no_scan') return p.scan == 0;
            if (this.attrFilter === 'no_cuisson') return p.cuisson == 0;
            return true;
        },
        get allSelected() {
            return this.selectedIds.length > 0;
        },
        toggleSelect(id) {
            const idx = this.selectedIds.indexOf(id);
            if (idx > -1) {
                this.selectedIds.splice(idx, 1);
            } else {
                this.selectedIds.push(id);
            }
        },
        toggleAll() {
            if (this.selectedIds.length > 0) {
                this.selectedIds = [];
            } else {
                this.selectedIds = @json($produits->pluck('id'));
            }
        },
        bulkAction(action) {
            if (this.selectedIds.length === 0) return;
            
            if (action === 'delete' && !confirm('Supprimer ' + this.selectedIds.length + ' produit(s) ?')) return;

            fetch('{{ route("produits.bulk-update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    ids: this.selectedIds,
                    action: action
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Erreur');
                }
            })
            .catch(e => {
                alert('Erreur réseau');
                console.error(e);
            });
        }
    }
}
</script>
@endsection
