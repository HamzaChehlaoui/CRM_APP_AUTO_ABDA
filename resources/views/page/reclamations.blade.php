@extends('layouts.mastere')
{{-- page Remarques --}}
    <link rel="icon" href="img/logo-dacia-oggi-removebg-preview.png" type="image/png" />

@section('title', 'Remarques - Tableau de Bord')

@section('content')

    <body class="h-full w-full font-sans bg-gray-50">

        <div class="flex h-screen w-screen overflow-hidden">

            <!-- Sidebar -->
            <x-sidebar />
            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->

                <header class="bg-white shadow-sm border-b border-gray-200 py-4 px-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Remarques</h1>
                            <p class="text-sm text-gray-500">Gérez les Remarques clients</p>
                        </div>
                        <div class="flex items-center space-x-4">
                               <a href="/notifications"> <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative" id="notificationBell">
                            <i class="fas fa-bell"></i>
                            @if($unreadCount > 0)
                            <span class="absolute top-0 right-0 h-5 w-5 bg-red-500 rounded-full border-2 border-white flex items-center justify-center">
                                <span class="text-xs text-white font-bold">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            </span>
                            @endif
                        </button>
                        </a>

                            <span class="h-6 border-l border-gray-300"></span>
                            <button
                                class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                                <span class="font-medium text-sm">{{ date('d/m/Y') }}</span>
                                <i class="fas fa-calendar-alt text-xs text-gray-500"></i>
                            </button>


                        </div>
                    </div>
                </header>
                @if (session('success') || session('error'))
                    <div id="toast-message"
                        class="fixed top-4 right-4 z-50 max-w-xs px-4 py-3 rounded shadow-lg text-white
        {{ session('success') ? 'bg-green-600' : 'bg-red-600' }}"
                        role="alert">
                        {{ session('success') ?? session('error') }}
                    </div>

                    <script>
                        setTimeout(() => {
                            const toast = document.getElementById('toast-message');
                            if (toast) {
                                toast.style.opacity = '0';
                                toast.style.transition = 'opacity 0.5s ease-out';
                                setTimeout(() => toast.remove(), 500);
                            }
                        }, 3000);
                    </script>
                @endif


                <livewire:reclamation-index />
            </div>
        </div>
        @include('page.add-reclamation')

        @include('page.button-loading')
    </body>
@endsection

</html>
