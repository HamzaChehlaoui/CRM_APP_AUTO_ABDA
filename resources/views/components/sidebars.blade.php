@php
    $user = Auth::user();
@endphp

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col z-10">
    <div
        class="bg-gradient-to-r from-nucleus-primary to-nucleus-hover text-white px-6 py-5 flex items-center space-x-3 relative overflow-hidden shadow-md">
        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 -translate-x-6"></div>
        <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
        <div
            class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-inner relative z-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 86" class="w-6 h-auto">
                <path fill="white"
                    d="m52.3 43-23 43H23L0 43 22.9 0h6.5L6.5 43l19.6 36.9L45.7 43 34.3 21.5l3.3-6.1L52.3 43zM42.5 0h-6.6L13.1 43l14.7 27.6 3.2-6.1L19.6 43 39.2 6l19.6 37-22.9 43h6.6l22.8-43L42.5 0z">
                </path>
            </svg>
        </div>
        <div class="relative z-10">
            <span class="font-bold text-xl tracking-tight">FollowUp</span>
            <span class="font-light text-xl tracking-tight">CRM</span>
            <div class="text-xs font-light text-white/80 mt-0.5">Solution de gestion automobile</div>
        </div>
    </div>

    <div class="p-4">
        <!-- Professional car-themed animation replacing the search box -->
        <div class="relative mb-4">
            <div
                class="w-full h-10 rounded-md border border-gray-200 bg-gradient-to-r from-blue-50 to-white flex items-center justify-center overflow-hidden">
                <!-- Subtle road line -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-3/4 h-px bg-blue-200"></div>
                </div>
                <!-- Professional car icon with smooth movement -->
                <div class="relative z-10 flex items-center space-x-3">
                    <i class="fas fa-car text-blue-600 text-sm"></i>
                    <div class="flex space-x-1">
                        <div class="w-1 h-1 bg-blue-400 rounded-full opacity-70 animate-pulse"></div>
                        <div class="w-1 h-1 bg-blue-400 rounded-full opacity-50 animate-pulse"
                            style="animation-delay: 0.3s;"></div>
                        <div class="w-1 h-1 bg-blue-400 rounded-full opacity-30 animate-pulse"
                            style="animation-delay: 0.6s;"></div>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="text-xs uppercase text-gray-500 font-semibold mb-3">Navigation</h2>
        <nav class="space-y-1">
            <a href="/dashboard"
                class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('dashboard') }}">
                <i class="fas fa-tachometer-alt mr-2 {{ iconClass('dashboard') }}"></i> Tableau de Bord
            </a>
            <a href="/clients"
                class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('clients') }}">
                <i class="fas fa-car mr-2 {{ iconClass('clients') }}"></i> Clients
            </a>
            {{-- <a href="/suivis"
                class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('suivis') }}">
                <i class="fas fa-calendar-alt mr-2 {{ iconClass('suivis') }}"></i> Suivis
            </a> --}}
            <a href="/notifications"
                class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('notifications') }}">
                <i class="fas fa-bell mr-2 {{ iconClass('notifications') }}"></i> Notifications
                <span class="ml-auto bg-red-100 text-red-500 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
            </a>
            <a href="/factures"
                class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('factures') }}">
                <i class="fas fa-file-invoice mr-2 {{ iconClass('factures') }}"></i> factures
            </a>
            <a href="/reclamations"
                class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('reclamations') }}">
                <i class="fas fa-clipboard mr-2 {{ iconClass('reclamations') }}"></i> Remarques

            </a>
            <a href="/statistiques"
                class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('statistiques') }}">
                <i class="fas fa-chart-bar mr-2 {{ iconClass('statistiques') }}"></i> Statistiques
            </a>
            <a href="/exporter"
                class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('exporter') }}">
                <i class="fas fa-file-export mr-2 {{ iconClass('exporter') }}"></i> Exporter
            </a>
            @if ($user && $user->role_id == 2)
                <a href="/register"
                    class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('register') }}">
                    <i class="fas fa-user-plus mr-2 {{ iconClass('register') }}"></i> Register
                </a>
                <a href="/users"
                    class="flex items-center py-2 px-3 rounded-md font-medium transition-colors duration-200 {{ activeClass('users') }}">
                    <i class="fas fa-users mr-2 {{ iconClass('users') }}"></i> Users
                </a>
            @endif
        </nav>
    </div>

    <div class="mt-auto p-4 border-t border-gray-200">
        <div class="flex items-center space-x-3">
            <div
                class="w-14 h-8 p-1 rounded-full bg-nucleus-primary text-white flex items-center justify-center font-semibold">
                {{ strtoupper(Str::substr(explode(' ', $user->name)[0], 0, 1) . Str::substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-medium text-gray-800 whitespace-nowrap">{{ $user->name }}</p>
                <p class="text-xs text-gray-500">Accès complet</p>
            </div>
            <div class="ml-auto flex space-x-2">
                <a href="{{ route('profile.edit') }}">
                    <button class="text-gray-500 hover:text-nucleus-primary transition-colors">
                        <i class="fas fa-cog"></i>
                    </button>
                </a>
                <!-- Enhanced logout button with modal -->
                <button type="button" onclick="showLogoutModal()"
                    class="group relative  text-gray-500 hover:text-red-600 transition-all duration-300 ease-in-out rounded-lg hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <i
                        class="fas fa-sign-out-alt transform group-hover:scale-110 transition-transform duration-300"></i>

                    <!-- Animated background effect -->
                    <div
                        class="absolute inset-0 rounded-lg bg-gradient-to-r from-red-500 to-pink-500 opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                    </div>
                </button>

                <!-- Logout form -->
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>

                <!-- Professional modal -->
                <div id="logoutModal"
                    class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 opacity-0 invisible transition-all duration-300 ease-in-out">

                    <div
                        class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform scale-95 transition-all duration-300 ease-in-out">

                        <!-- Modal header -->
                        <div class="px-6 py-8 text-center">
                            <!-- Warning icon -->
                            <div
                                class="mx-auto flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                Confirm Logout
                            </h3>

                            <!-- Description -->
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Are you sure you want to log out? Your current session will be ended and you will need
                                to log in again.
                            </p>
                        </div>

                        <!-- Action buttons -->
                        <div class="px-6 py-4 bg-gray-50 rounded-b-2xl flex flex-col sm:flex-row gap-3 sm:gap-2">

                            <!-- Cancel button -->
                            <button onclick="hideLogoutModal()"
                                class="flex-1 px-4 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 ease-in-out transform hover:scale-[1.02] active:scale-[0.98]">
                                Cancel
                            </button>

                            <!-- Confirm button -->
                            <button onclick="confirmLogout()"
                                class="flex-1 px-4 py-3 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 rounded-lg hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-lg hover:shadow-xl transition-all duration-200 ease-in-out transform hover:scale-[1.02] active:scale-[0.98]">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Log Out
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Enhanced script -->
                <script>
                    function showLogoutModal() {
                        const modal = document.getElementById('logoutModal');
                        const modalContent = modal.querySelector('div > div');

                        // Show modal
                        modal.classList.remove('opacity-0', 'invisible');
                        modal.classList.add('opacity-100', 'visible');

                        // Animate content
                        setTimeout(() => {
                            modalContent.classList.remove('scale-95');
                            modalContent.classList.add('scale-100');
                        }, 10);

                        // Prevent background scrolling
                        document.body.style.overflow = 'hidden';
                    }

                    function hideLogoutModal() {
                        const modal = document.getElementById('logoutModal');
                        const modalContent = modal.querySelector('div > div');

                        // Animate content
                        modalContent.classList.remove('scale-100');
                        modalContent.classList.add('scale-95');

                        // Hide modal
                        setTimeout(() => {
                            modal.classList.remove('opacity-100', 'visible');
                            modal.classList.add('opacity-0', 'invisible');
                        }, 200);

                        // Allow scrolling again
                        document.body.style.overflow = 'auto';
                    }

                    function confirmLogout() {
                        // Add loading effect
                        const confirmBtn = event.target;
                        const originalText = confirmBtn.innerHTML;

                        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Logging out...';
                        confirmBtn.disabled = true;

                        // Short delay for visual effect
                        setTimeout(() => {
                            document.getElementById('logout-form').submit();
                        }, 800);
                    }

                    // Close modal by clicking outside
                    document.getElementById('logoutModal').addEventListener('click', function(e) {
                        if (e.target === this) {
                            hideLogoutModal();
                        }
                    });

                    // Close modal with Escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            hideLogoutModal();
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</aside>
