<!DOCTYPE html>
<html lang="fr" class="h-full w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - FollowUp CRM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        nucleus: {
                            primary: '#3A5CDB',
                            hover: '#2D4EC0',
                            light: '#F2F6FF',
                            dark: '#0F1A42',
                            gray: '#F5F7FA',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'input': '0 2px 4px rgba(0, 0, 0, 0.05)',
                        'card': '0 10px 25px rgba(58, 92, 219, 0.07)',
                    }
                },
            },
        };
    </script>
</head>
<body class="h-full w-full font-sans bg-gray-50">
    <div class="flex h-screen w-screen overflow-hidden">

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
                <h2 class="text-xs uppercase text-gray-500 font-semibold mb-3">Navigation</h2>
                <nav class="space-y-1">
                    <a href="/manager" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-tachometer-alt mr-2 text-gray-500"></i>
                        Tableau de Bord
                    </a>
                    <a href="/prospectsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-users mr-2 text-gray-500"></i>
                        Prospects
                    </a>
                    <a href="/suivisDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                        Suivis
                    </a>
                    <a href="/notificationsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-bell mr-2 text-gray-500"></i>
                        Notifications
                        <span class="ml-auto bg-red-100 text-red-500 text-xs font-semibold px-2 py-0.5 rounded-full">3</span>
                    </a>
                    <a href="/clientsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-car mr-2  text-gray-500"></i>
                        Clients
                    </a>
                    <a href="/entretiensDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-wrench mr-2 text-gray-500"></i>
                        Entretiens
                        <span class="ml-auto bg-yellow-100 text-yellow-500 text-xs font-semibold px-2 py-0.5 rounded-full">8</span>
                    </a>
                    <a href="/reclamationsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-exclamation-triangle mr-2 text-gray-500"></i>
                        Réclamations
                        <span class="ml-auto bg-orange-100 text-orange-500 text-xs font-semibold px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="/statistiquesDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-chart-bar mr-2 text-gray-500"></i>
                        Statistiques
                    </a>
                    <a href="/exporterDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-file-export mr-2 text-gray-500"></i>
                        Exporter
                    </a>
                    <a href="/register" class="flex items-center py-2 px-3 rounded-md bg-nucleus-light text-nucleus-primary font-medium ">
                        <i class="fas fa-user-plus mr-2 text-nucleus-primary"></i>
                        Register
                    </a>

                </nav>
            </div>

            <div class="mt-auto p-4 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-nucleus-primary text-white flex items-center justify-center font-semibold">DG</div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Accès complet</p>
                    </div>
                    <div class="ml-auto flex space-x-2">
                        <a href="{{route('profile.edit')}}">
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
        <main class="flex-1 flex items-center justify-center bg-gray-50">
    <div class="min-h-screen flex flex-col justify-center">
        <div class="px-6 py-8 mx-auto w-full max-w-3xl">
            <div class="flex items-center justify-center mb-8">
                <div class="w-10 h-10 rounded-md flex items-center justify-center bg-blue-600 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 86" class="w-6 h-auto">
                        <path fill="white" d="m52.3 43-23 43H23L0 43 22.9 0h6.5L6.5 43l19.6 36.9L45.7 43 34.3 21.5l3.3-6.1L52.3 43zM42.5 0h-6.6L13.1 43l14.7 27.6 3.2-6.1L19.6 43 39.2 6l19.6 37-22.9 43h6.6l22.8-43L42.5 0z"></path>
                    </svg>
                </div>
                <span class="font-bold text-2xl tracking-tight text-gray-800">FollowUp CRM</span>
            </div>
    @if(session('success'))
  <div class="mb-4 p-4 text-green-800 bg-green-200 rounded">
    {{ session('success') }}
  </div>
@endif
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Créer un compte</h1>
                    <p class="text-gray-500">Remplissez le formulaire ci-dessous pour vous inscrire</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nom complet')" class="block text-sm font-medium text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-user"></i>
                                </div>
                                <x-text-input id="name"
                                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-gray-50"
                                            type="text"
                                            name="name"
                                            :value="old('name')"
                                            required
                                            autofocus
                                            autocomplete="name"
                                            placeholder="John Doe" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Adresse e-mail')" class="block text-sm font-medium text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <x-text-input id="email"
                                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-gray-50"
                                            type="email"
                                            name="email"
                                            :value="old('email')"
                                            required
                                            autocomplete="username"
                                            placeholder="vous@example.com" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Branch Select -->
                        <div>
                            <x-input-label for="branch_id" :value="__('Succursale')" class="block text-sm font-medium text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-building"></i>
                                </div>
                                <select name="branch_id" id="branch_id" required
                                        class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-gray-50 appearance-none">
                                    <option value="">-- Sélectionner une succursale --</option>
                                    @foreach(\App\Models\Branch::all() as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                        </div>



                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Mot de passe')" class="block text-sm font-medium text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <x-text-input id="password"
                                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-gray-50"
                                            type="password"
                                            name="password"
                                            required
                                            autocomplete="new-password"
                                            placeholder="••••••••" />
                                <button type="button" onclick="togglePassword('password', 'password-toggle')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-400 hover:text-gray-500">
                                    <i class="fas fa-eye" id="password-toggle"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="block text-sm font-medium text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <x-text-input id="password_confirmation"
                                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-gray-50"
                                            type="password"
                                            name="password_confirmation"
                                            required
                                            autocomplete="new-password"
                                            placeholder="••••••••" />
                                <button type="button" onclick="togglePassword('password_confirmation', 'confirmation-toggle')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-400 hover:text-gray-500">
                                    <i class="fas fa-eye" id="confirmation-toggle"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col md:flex-row items-center justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <input id="terms" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" required>
                            <label for="terms" class="ml-2 text-sm text-gray-600">J'accepte les <a href="#" class="text-blue-600 hover:underline">conditions d'utilisation</a></label>
                        </div>

                        <a class="text-sm text-blue-600 hover:text-blue-800 font-medium" href="">
                            {{ __() }}
                        </a>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 shadow-md flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i>
                            {{ __('Créer mon compte') }}
                        </button>
                    </div>
                </form>


            </div>

            <div class="mt-6 text-center text-sm text-gray-500">
                <p>&copy; 2025 FollowUp CRM. Tous droits réservés.</p>
            </div>
        </div>
    </div>
        </main>
    </div>
    <script>
        function togglePassword(inputId, toggleId) {
            const passwordInput = document.getElementById(inputId);
            const passwordToggle = document.getElementById(toggleId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
