<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection Employé - HACCP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-500 to-blue-700 min-h-screen">
    <div class="container mx-auto px-4 py-8">

        {{-- En-tête avec logo --}}
        <div class="mb-12">
            {{-- Logo à gauche --}}
            <div class="flex items-center gap-4 mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Huitres Grolleau-Its" class="h-24 w-24 drop-shadow-2xl">
                <div>
                    <h1 class="text-5xl font-bold text-white">🍴 HACCP</h1>
                </div>
            </div>
            <p class="text-2xl text-white text-center">Sélectionnez votre nom pour commencer</p>
        </div>

        {{-- Grille des employés --}}
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($employes as $employe)
                    <a href="{{ route('employe-session.select', $employe) }}"
                       class="group block bg-white rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 p-8 text-center">

                        {{-- Icône/Avatar --}}
                        <div class="mb-4 flex justify-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-4xl font-bold group-hover:from-green-400 group-hover:to-green-600 transition-all duration-300">
                                {{ strtoupper(substr($employe->name, 0, 1)) }}
                            </div>
                        </div>

                        {{-- Nom --}}
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                            {{ $employe->name }}
                        </h3>

                        {{-- Rôle ou info supplémentaire --}}
                        @if($employe->email)
                            <p class="text-sm text-gray-500 mt-2">{{ $employe->email }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Pied de page --}}
        <div class="text-center mt-12">
            <p class="text-white text-sm">
                © {{ date('Y') }} Système HACCP - Tous droits réservés
            </p>
        </div>

    </div>

    {{-- Auto-rafraîchissement toutes les heures pour maintenir la session active --}}
    <script>
        // Rafraîchir la page toutes les heures si aucune activité
        setTimeout(() => {
            location.reload();
        }, 3600000); // 1 heure
    </script>
</body>
</html>
