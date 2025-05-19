<!DOCTYPE html>
<html lang="fr" class="h-full w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - FollowUp CRM</title>
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
<body class="h-full w-full font-sans">
    <div class="flex h-screen w-screen">
        <div class="w-1/2 hidden md:block relative">
            <img src="https://images8.alphacoders.com/131/1311546.jpg"
                 alt="Cover"
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-nucleus-dark bg-opacity-60 p-12 text-white flex flex-col justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-md flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 86" class="w-full h-auto">
                            <path fill="white" d="m52.3 43-23 43H23L0 43 22.9 0h6.5L6.5 43l19.6 36.9L45.7 43 34.3 21.5l3.3-6.1L52.3 43zM42.5 0h-6.6L13.1 43l14.7 27.6 3.2-6.1L19.6 43 39.2 6l19.6 37-22.9 43h6.6l22.8-43L42.5 0z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight">FollowUp CRM</span>
                </div>

                <div>
                    <svg class="w-10 h-10 text-nucleus-primary/60 mb-6" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M12 15H6.11A8 8 0 0114 8.86V5.09A12 12 0 002 17v9a2 2 0 002 2h8a2 2 0 002-2v-9a2 2 0 00-2-2zm18 0h-5.89A8 8 0 0132 8.86V5.09A12 12 0 0020 17v9a2 2 0 002 2h8a2 2 0 002-2v-9a2 2 0 00-2-2z"></path>
                    </svg>
                    <blockquote class="text-2xl font-medium leading-relaxed mb-6">
                        Bienvenue sur notre CRM. Veuillez vous connecter pour accéder à votre compte.
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                            <span class="text-lg font-semibold text-white">AB</span>
                        </div>
                        <div>
                            <p class="font-medium">Auto Abda</p>
                            <p class="text-sm text-gray-300">Auto Abda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-6 bg-gradient-to-br from-white to-blue-100">
            <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-10 border border-gray-100">
                <div class="text-center mb-8">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 86" class="w-6 h-auto">
                            <path fill="#3A5CDB" d="m52.3 43-23 43H23L0 43 22.9 0h6.5L6.5 43l19.6 36.9L45.7 43 34.3 21.5l3.3-6.1L52.3 43zM42.5 0h-6.6L13.1 43l14.7 27.6 3.2-6.1L19.6 43 39.2 6l19.6 37-22.9 43h6.6l22.8-43L42.5 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Bienvenue</h1>
                    <p class="text-gray-500">Connectez-vous pour continuer à utiliser notre CRM.</p>
                </div>
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

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
                                          autofocus
                                          autocomplete="username"
                                          placeholder="vous@example.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <x-input-label for="password" :value="__('Mot de passe')" class="block text-sm font-medium text-gray-700" />
                            @if (Route::has('password.request'))
                                <a class="text-sm text-blue-600 hover:text-blue-800 font-medium" href="{{ route('password.request') }}">
                                    {{ __('Mot de passe oublié ?') }}
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <x-text-input id="password"
                                          class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-gray-50"
                                          type="password"
                                          name="password"
                                          required
                                          autocomplete="current-password"
                                          placeholder="••••••••" />
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-400 hover:text-gray-500">
                                <i class="fas fa-eye" id="password-toggle"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                        </label>
                    </div>

                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3.5 px-4 rounded-lg transition duration-200 shadow-md mt-6">
    {{ __('Se connecter') }}
</button>

                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('password-toggle');

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
