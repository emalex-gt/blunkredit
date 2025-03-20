<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Inicio') }}
                    </x-nav-link>
                    @if(auth()->user()->can('configuration') || auth()->user()->can('arqueo'))
                        <x-dropdown align="left" width="60" class="inline-flex">
                            <x-slot name="trigger">
                                <x-nav-link class="cursor-pointer" style="padding:25px 0">
                                    {{ __('Configuración') }}
                                </x-nav-link>
                            </x-slot>
                            <x-slot name="content">
                                <div class="w-60 text-center">
                                    @can('arqueo')
                                        <x-dropdown-link href="{{ route('arqueo') }}" :active="request()->routeIs('arqueo')">
                                            {{ __('Arqueo') }}
                                        </x-dropdown-link>
                                    @endcan
                                    @can('configuration')
                                        <x-dropdown-link href="{{ route('usuarios') }}" :active="request()->routeIs('usuarios')">
                                            {{ __('Usuarios') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('inversores') }}" :active="request()->routeIs('inversores')">
                                            {{ __('Inversores') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('fondos') }}" :active="request()->routeIs('fondos')">
                                            {{ __('Fondos') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('tipo_gastos') }}" :active="request()->routeIs('tipo_gastos')">
                                            {{ __('Tipos de Gasto') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('gastos') }}" :active="request()->routeIs('gastos')">
                                            {{ __('Gastos') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('tecnologias') }}" :active="request()->routeIs('tecnologias')">
                                            {{ __('Tecnologías') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('garantias') }}" :active="request()->routeIs('garantias')">
                                            {{ __('Garantías') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('lineas-de-credito') }}" :active="request()->routeIs('lineas-de-credito')">
                                            {{ __('Líneas de Crédito') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('plazos') }}" :active="request()->routeIs('plazos')">
                                            {{ __('Plazos') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('intereses') }}" :active="request()->routeIs('intereses')">
                                            {{ __('Intereses') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('politicas') }}" :active="request()->routeIs('politicas')">
                                            {{ __('Políticas') }}
                                        </x-dropdown-link>
                                    @endcan
                                </div>
                            </x-slot>
                        </x-dropdown>
                    @endif

                    @can('clients')
                        <x-dropdown align="left" width="60" class="inline-flex">
                            <x-slot name="trigger">
                                <x-nav-link class="cursor-pointer" style="padding:25px 0">
                                    {{ __('Créditos') }}
                                </x-nav-link>
                            </x-slot>
                            <x-slot name="content">
                                <div class="w-60 text-center">
                                    <x-dropdown-link href="{{ route('clientes') }}" :active="request()->routeIs('clientes')">
                                        {{ __('Clientes') }}
                                    </x-dropdown-link>
                                </div>
                                @can('credits')
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('creditos-lista') }}" :active="request()->routeIs('creditos-lista')">
                                            {{ __('Créditos') }}
                                        </x-dropdown-link>
                                    </div>
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('creditos') }}" :active="request()->routeIs('creditos')">
                                            {{ __('Buscar Crédito') }}
                                        </x-dropdown-link>
                                    </div>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    @endcan

                        <x-dropdown align="left" width="60" class="inline-flex">
                    @if(auth()->user()->can('report-colocacion') || auth()->user()->can('reports'))
                            <x-slot name="trigger">
                                <x-nav-link class="cursor-pointer" style="padding:25px 0">
                                    {{ __('Reportes') }}
                                </x-nav-link>
                            </x-slot>
                            <x-slot name="content">
                                @can('reports')
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('reporte-recuperacion') }}" :active="request()->routeIs('reporte-recuperacion')">
                                            {{ __('Recuperación') }}
                                        </x-dropdown-link>
                                    </div>
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('reporte-adelantados') }}" :active="request()->routeIs('reporte-adelantados')">
                                            {{ __('Ingresos por Aplicar') }}
                                        </x-dropdown-link>
                                    </div>
                                @endcan
                                @can('report-colocacion')
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('reporte-colocacion') }}" :active="request()->routeIs('reporte-colocacion')">
                                            {{ __('Colocación del Mes') }}
                                        </x-dropdown-link>
                                    </div>
                                @endcan
                                @can('reports')
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('reporte-morosos') }}" :active="request()->routeIs('reporte-morosos')">
                                            {{ __('Morosos') }}
                                        </x-dropdown-link>
                                    </div>
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('reporte-proyeccion') }}" :active="request()->routeIs('reporte-proyeccion')">
                                            {{ __('Proyección de Pagos') }}
                                        </x-dropdown-link>
                                    </div>
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('reporte-creditos') }}" :active="request()->routeIs('reporte-creditos')">
                                            {{ __('Saldos de Clientes') }}
                                        </x-dropdown-link>
                                    </div>
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('reporte-diario') }}" :active="request()->routeIs('reporte-diario')">
                                            {{ __('Diario') }}
                                        </x-dropdown-link>
                                    </div>
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('reporte-informe-diario') }}" :active="request()->routeIs('reporte-informe-diario')">
                                            {{ __('Informe Diario') }}
                                        </x-dropdown-link>
                                    </div>
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('reporte-arqueo') }}" :active="request()->routeIs('reporte-arqueo')">
                                            {{ __('Arqueo de Caja') }}
                                        </x-dropdown-link>
                                    </div>
                                    <div class="w-60 text-center">
                                        <x-dropdown-link href="{{ route('reporte-corte-caja') }}" :active="request()->routeIs('reporte-corte-caja')">
                                            {{ __('Corte de Caja') }}
                                        </x-dropdown-link>
                                    </div>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    @endif
                    
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            @can('configuration')
                <x-responsive-nav-link href="#">
                    {{ __('Configuración') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
