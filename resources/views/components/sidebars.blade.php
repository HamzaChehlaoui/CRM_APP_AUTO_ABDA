@php
    $user = Auth::user();
@endphp

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col z-10">
    <div class="bg-gradient-to-r from-nucleus-primary to-nucleus-hover text-white px-6 py-5 flex items-center space-x-3 relative overflow-hidden shadow-md">
        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 -translate-x-6"></div>
        <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
        <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-inner relative z-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 86" class="w-6 h-auto">
                <path fill="white" d="m52.3 43-23 43H23L0 43 22.9 0h6.5L6.5 43l19.6 36.9L45.7 43 34.3 21.5l3.3-6.1L52.3 43zM42.5 0h-6.6L13.1 43l14.7 27.6 3.2-6.1L19.6 43 39.2 6l19.6 37-22.9 43h6.6l22.8-43L42.5 0z"></path>
            </svg>
        </div>
        <div class="relative z-10">
            <span class="font-bold text-xl tracking-tight">FollowUp</span>
            <span class="font-light text-xl tracking-tight">CRM</span>
            <div class="text-xs font-light text-white/80 mt-0.5">Solution de gestion automobile</div>
        </div>
    </div>

    <div class="p-4">
        <div class="relative mb-4">
            <input type="text" placeholder="Rechercher..."
                class="w-full rounded-md border border-gray-200 py-2 pl-10 pr-4 text-sm focus:border-nucleus-primary focus:outline-none focus:ring-1 focus:ring-nucleus-primary">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>

        <h2 class="text-xs uppercase text-gray-500 font-semibold mb-3">Navigation</h2>
        <nav class="space-y-1">
            <a href="/dashboard" class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('dashboard') }}">
                <i class="fas fa-tachometer-alt mr-2 {{ iconClass('dashboard') }}"></i> Tableau de Bord
            </a>
            <a href="/clients" class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('clients') }}">
                <i class="fas fa-car mr-2 {{ iconClass('clients') }}"></i> Clients
            </a>
            <a href="/suivis" class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('suivis') }}">
                <i class="fas fa-calendar-alt mr-2 {{ iconClass('suivis') }}"></i> Suivis
            </a>
            <a href="/notifications" class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('notifications') }}">
                <i class="fas fa-bell mr-2 {{ iconClass('notifications') }}"></i> Notifications
                <span class="ml-auto bg-red-100 text-red-500 text-xs font-semibold px-2 py-0.5 rounded-full">3</span>
            </a>
            <a href="/factures" class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('factures') }}">
                <i class="fas fa-file-invoice mr-2 {{ iconClass('factures') }}"></i> factures

            </a>


            <a href="/reclamations" class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('reclamations') }}">
                <i class="fas fa-exclamation-triangle mr-2 {{ iconClass('reclamations') }}"></i> Réclamations
                <span class="ml-auto bg-orange-100 text-orange-500 text-xs font-semibold px-2 py-0.5 rounded-full">4</span>
            </a>
            <a href="/statistiques" class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('statistiques') }}">
                <i class="fas fa-chart-bar mr-2 {{ iconClass('statistiques') }}"></i> Statistiques
            </a>
            <a href="/exporter" class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('exporter') }}">
                <i class="fas fa-file-export mr-2 {{ iconClass('exporter') }}"></i> Exporter
            </a>
            @if($user && $user->role_id==2)
            <a href="/register" class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('register') }}">
                <i class="fas fa-user-plus mr-2 {{ iconClass('register') }}"></i> Register
            </a>
            <a href="/users" class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('users') }}">
                <i class="fas fa-users mr-2 {{ iconClass('users') }}"></i> Users
            </a>
            @endif
        </nav>
    </div>

    <div class="mt-auto p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-nucleus-primary text-white flex items-center justify-center font-semibold">
                    {{ strtoupper(Str::substr(explode(' ', $user->name)[0], 0, 1) . Str::substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
            </div>
        <div>
                <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                <p class="text-xs text-gray-500">Accès complet</p>
            </div>
            <div class="ml-auto flex space-x-2">
                <a href="{{ route('profile.edit') }}">
                    <button class="text-gray-500 hover:text-nucleus-primary transition-colors">
                        <i class="fas fa-cog"></i>
                    </button>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-gray-500 hover:text-nucleus-primary transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
