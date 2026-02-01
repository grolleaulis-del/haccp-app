<nav x-data="{ open: false, menuOpen: false }" class="touch-topbar">
    <!-- Primary Navigation Menu -->
    <div class="touch-topbar-inner max-w-7xl mx-auto">
        <div class="touch-topbar-row">
            <div class="touch-branding">
                <div class="touch-logo">
                    <a href="{{ route('dashboard') }}" class="touch-logo-link flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Huitres Grolleau-Its" class="h-10 w-10">
                        <x-application-logo class="hidden h-9 w-auto fill-current" />
                    </a>
                    <div class="touch-brand-name">{{ config('app.name', 'HACCP') }}</div>
                </div>

                <!-- Navigation Links -->
                <div class="touch-nav hidden sm:flex">
                    <x-nav-link class="touch-nav-link" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('🏠 Accueil') }}
                    </x-nav-link>

                    <!-- Dropdown Menu pour les autres fonctionnalités -->
                    <div class="relative">
                        <button @click="menuOpen = !menuOpen" @click.away="menuOpen = false" class="touch-nav-link flex items-center gap-1 px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">
                            {{ __('📋 Menu') }}
                            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': menuOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </button>
                        
                        <div x-show="menuOpen" class="absolute left-0 mt-0 w-64 bg-white rounded-lg shadow-lg z-50">
                            <a href="{{ route('usage-quotidien.index') }}" class="block w-full text-left px-4 py-3 text-gray-800 hover:bg-blue-50 rounded-t-lg text-sm">
                                📦 Usage Quotidien
                            </a>
                            <a href="{{ route('usage-quotidien.historique') }}" class="block w-full text-left px-4 py-3 text-gray-800 hover:bg-blue-50 text-sm">
                                📜 Historique Lots
                            </a>
                            <a href="{{ route('scan-etiquette.index') }}" class="block w-full text-left px-4 py-3 text-gray-800 hover:bg-blue-50 text-sm">
                                🔍 Traçabilité (Scan)
                            </a>
                            <a href="{{ route('cuisson-refroidissement.index') }}" class="block w-full text-left px-4 py-3 text-gray-800 hover:bg-blue-50 text-sm">
                                🔥 Cuisson/Refroidissement
                            </a>
                            <a href="{{ route('produits.index') }}" class="block w-full text-left px-4 py-3 text-gray-800 hover:bg-blue-50 text-sm">
                                🏷️ Produits
                            </a>
                            <a href="{{ route('arrivages.index') }}" class="block w-full text-left px-4 py-3 text-gray-800 hover:bg-blue-50 text-sm">
                                🚚 Arrivages
                            </a>
                            <a href="{{ route('controle.index') }}" class="block w-full text-left px-4 py-3 text-gray-800 hover:bg-blue-50 text-sm">
                                ✅ Contrôle
                            </a>
                            <a href="{{ route('temperatures.index') }}" class="block w-full text-left px-4 py-3 text-gray-800 hover:bg-blue-50 text-sm">
                                🌡️ Températures
                            </a>
                            <a href="{{ route('nettoyage.index') }}" class="block w-full text-left px-4 py-3 text-gray-800 hover:bg-blue-50 rounded-b-lg text-sm">
                                🧹 Nettoyage
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                {{-- Affichage de l'employé actif --}}
                @if(session('employe_actif_name'))
                    <div class="flex items-center gap-2 px-4 py-2 bg-green-100 rounded-lg">
                        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(session('employe_actif_name'), 0, 1)) }}
                        </div>
                        <div class="text-sm">
                            <div class="font-semibold text-gray-800">{{ session('employe_actif_name') }}</div>
                            <div class="text-xs text-gray-600">Employé actif</div>
                        </div>
                        <form action="{{ route('employe-session.deselect') }}" method="POST" class="ml-2">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs">
                                ✖
                            </button>
                        </form>
                    </div>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="touch-user-trigger">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('users.index')">
                            👥 {{ __('Gestion utilisateurs') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('settings.index')">
                            ⚙️ {{ __('Paramètres') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger - Version améliorée pour mobile -->
            <div class="flex items-center gap-3 sm:hidden">
                {{-- Badge employé mobile --}}
                @if(session('employe_actif_name'))
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(session('employe_actif_name'), 0, 1)) }}
                    </div>
                @endif

                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-lg text-gray-700 bg-white border-2 border-gray-300 hover:bg-gray-100 hover:border-gray-400 focus:outline-none focus:bg-gray-100 focus:border-gray-400 transition duration-150 ease-in-out shadow-sm">
                    <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu - Menu mobile amélioré -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-50 border-t-4 border-blue-500 shadow-lg">
        {{-- Employé actif en mobile --}}
        @if(session('employe_actif_name'))
            <div class="px-5 py-4 bg-gradient-to-r from-green-50 to-green-100 border-b-2 border-green-300">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow">
                        {{ strtoupper(substr(session('employe_actif_name'), 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-gray-900 text-base">{{ session('employe_actif_name') }}</div>
                        <div class="text-sm text-green-700">Employé actif</div>
                    </div>
                    <form action="{{ route('employe-session.deselect') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 shadow-sm">
                            Changer
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <div class="py-3 space-y-1">
            <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-blue-500 hover:bg-blue-50" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                🏠 Accueil
            </x-responsive-nav-link>
            <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-blue-500 hover:bg-blue-50" :href="route('usage-quotidien.index')" :active="request()->routeIs('usage-quotidien.index')">
                📦 Usage Quotidien
            </x-responsive-nav-link>
            <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-blue-500 hover:bg-blue-50" :href="route('usage-quotidien.historique')" :active="request()->routeIs('usage-quotidien.historique')">
                📜 Historique Lots
            </x-responsive-nav-link>
            <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-blue-500 hover:bg-blue-50" :href="route('produits.index')" :active="request()->routeIs('produits.*')">
                🏷️ Produits
            </x-responsive-nav-link>
            <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-blue-500 hover:bg-blue-50" :href="route('arrivages.index')" :active="request()->routeIs('arrivages.*')">
                🚚 Arrivages
            </x-responsive-nav-link>
            <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-blue-500 hover:bg-blue-50" :href="route('controle.index')" :active="request()->routeIs('controle.*')">
                ✅ Contrôle
            </x-responsive-nav-link>
            <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-blue-500 hover:bg-blue-50" :href="route('temperatures.index')" :active="request()->routeIs('temperatures.*')">
                🌡️ Températures
            </x-responsive-nav-link>
            <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-blue-500 hover:bg-blue-50" :href="route('nettoyage.index')" :active="request()->routeIs('nettoyage.*')">
                🧹 Nettoyage
            </x-responsive-nav-link>
            <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-blue-500 hover:bg-blue-50" :href="route('cuisson-refroidissement.index')" :active="request()->routeIs('cuisson-refroidissement.*')">
                🔥 Cuisson/Refroidissement
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-3 pb-3 border-t-2 border-gray-300 bg-gray-100">
            <div class="px-5 mb-4">
                <div class="font-bold text-base text-gray-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-600">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-purple-500 hover:bg-purple-50" :href="route('users.index')">
                    👥 Gestion utilisateurs
                </x-responsive-nav-link>

                <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-purple-500 hover:bg-purple-50" :href="route('settings.index')">
                    ⚙️ Paramètres
                </x-responsive-nav-link>

                <x-responsive-nav-link class="text-lg py-4 px-5 font-medium border-l-4 border-transparent hover:border-purple-500 hover:bg-purple-50" :href="route('profile.edit')">
                    👤 Profil
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link class="text-lg py-4 px-5 font-bold text-red-600 border-l-4 border-transparent hover:border-red-500 hover:bg-red-50" :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        🚪 Déconnexion
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
