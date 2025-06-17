@extends('layouts.mastere')

@section('title', 'Reclamation - Tableau de Bord')

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
                            <h1 class="text-2xl font-bold text-gray-800">Réclamations</h1>
                            <p class="text-sm text-gray-500">Gérez les réclamations clients</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative">
                                <i class="fas fa-bell"></i>
                                <span
                                    class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full border-2 border-white"></span>
                            </button>

                            <span class="h-6 border-l border-gray-300"></span>
                            <button
                                class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                                <span class="font-medium text-sm">{{ date('d/m/Y') }}</span>
                                <i class="fas fa-calendar-alt text-xs text-gray-500"></i>
                            </button>


                        </div>
                    </div>
                </header>

                <livewire:reclamation-index />

            </div>
        </div>
        @include('page.add-reclamation')

        @include('page.button-loading')
    </body>
@endsection

</html>
