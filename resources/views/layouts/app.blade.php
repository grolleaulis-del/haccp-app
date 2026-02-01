<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased touch-theme">
        @php $slot = $slot ?? null; @endphp
        <div class="touch-shell min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="touch-page-header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="touch-main">
                {{-- Support both component slots and Blade sections --}}
                @isset($slot)
                    {{ $slot }}
                @endisset
                @yield('content')
            </main>
        </div>

        {{-- Système de détection d'inactivité optimisé --}}
        <script>
            let inactivityTimer;
            // Récupérer le délai depuis les paramètres (en minutes, converti en millisecondes)
            const INACTIVITY_TIMEOUT = {{ \App\Models\Setting::get('inactivity_timeout', 5) }} * 60 * 1000;

            function resetInactivityTimer() {
                clearTimeout(inactivityTimer);

                inactivityTimer = setTimeout(() => {
                    // Redirection vers la page de sélection employé
                    window.location.href = '{{ route("employe-session.index") }}';
                }, INACTIVITY_TIMEOUT);
            }

            // Événements à surveiller pour réinitialiser le timer
            ['mousedown', 'keypress', 'touchstart', 'click'].forEach(event => {
                document.addEventListener(event, resetInactivityTimer, true);
            });

            // Démarrer le timer au chargement
            resetInactivityTimer();
        </script>
    </body>
</html>
