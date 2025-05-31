@extends('layouts.mastere')

@section('title', 'Suivis - Tableau de Bord')

@section('content')
<body class="h-full w-full font-sans bg-gray-50">
<div class="flex h-screen w-screen overflow-hidden">

<!-- Sidebar -->
        <x-sidebar/>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 py-4 px-6">
                <div class="flex items-center justify-between">
                <div>
                        <h1 class="text-2xl font-bold text-gray-800">Suivis</h1>
                        <p class="text-sm text-gray-500">Gérez les suivis de vos prospects</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors">
                            <i class="fas fa-question-circle"></i>
                        </button>
                        <span class="h-6 border-l border-gray-300"></span>
                        <button class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                            <span class="font-medium text-sm">Aujourd'hui</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <div class="flex-1 p-6 overflow-y-auto">
                <!-- Calendar Navigation -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-4">
    <button class="p-2 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-50" title="Afficher la liste des branches">
        <i class="fas fa-chevron-down"></i>
    </button>
    <h2 class="text-xl font-semibold">Filtrer par branche</h2>

</div>
                    @if(auth()->user()->role_id!=1 && auth()->user()->role_id!=2)
                    <div class="flex space-x-2">
                        <button class="flex items-center justify-center space-x-2 rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <i class="fas fa-plus"></i>
                            <span>Nouveau Suivi</span>
                        </button>
                    </div>
                    @endif
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <form method="GET" action="{{ route('page.suivis') }}" class="mb-4">
    <select name="branch" onchange="this.form.submit()" class="border rounded p-2">
        <option value="all" {{ $selectedBranch == 'all' ? 'selected' : '' }}>all</option>
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ $selectedBranch == $branch->id ? 'selected' : '' }}>
                {{ $branch->name }}
            </option>
        @endforeach
    </select>
</form>
                    </nav>
                </div>

                <!-- Follow-ups List -->
                <div class="space-y-4">
<!-- Follow-up Cards Container -->
<div class="bg-white rounded-xl shadow-card p-4">
    <div class="flex flex-col space-y-4">
        @foreach($suivis as $suivi)
            <div class="flex p-4 border rounded-md bg-white shadow-sm">
                <div class="mr-4">
<div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium mr-2"> {{ strtoupper(substr($suivi->client->full_name, 0, 2)) }}</div>

                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{$suivi->client->full_name}}</h3>
                            <div class="flex items-center mt-1 text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                <span>{{$suivi->date_suivi}}</span>
                                <span class="px-2 py-0.5 rounded-full follow-type-call text-xs"></span>

                                <span class="px-2 py-0.5 rounded-full status-interested text-xs">{{$suivi->status}}</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="p-1 rounded-md text-gray-400 hover:text-gray-500">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="p-1 rounded-md text-gray-400 hover:text-gray-500">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mt-3 bg-gray-50 p-3 rounded-md">
                        <p class="text-sm text-gray-600">{{$suivi->note}}</p>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <div class="flex gap-2">
                        <div class="flex items-center">
                        <i class="fas fa-phone mr-1.5"></i>
                                <div class="m-1">
                                <p class="text-xs text-gray-500">{{$suivi->client->phone}}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                        <i class="fas fa-envelope mr-1.5"></i>
                                <div class="m-1">
                                <p class="text-xs text-gray-500">{{$suivi->client->email}}</p>
                            </div>
                        </div>
                        </div>
                        <p><strong>Branche:</strong> {{ $suivi->client->branch->name ?? ' indéfini' }}</p>

                        <div class="flex space-x-2">
                            <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-phone mr-1.5"></i>
                                Appeler
                            </button>
                            <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-envelope mr-1.5"></i>
                                Email
                            </button>
                            <button class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                                <i class="fas fa-check mr-1.5"></i>
                                Terminé
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="mt-4">
            {{$suivis->links()}}
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
</body>
@endsection
</html>
