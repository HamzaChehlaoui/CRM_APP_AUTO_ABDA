@extends('layouts.mastere')

@section('title', 'Users - Tableau de Bord')

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
                            <h1 class="text-2xl font-bold text-gray-800">Utilisateurs</h1>
                            <p class="text-sm text-gray-500">Gérez Utilisateurs</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="/notifications"> <button
                                    class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative"
                                    id="notificationBell">
                                    <i class="fas fa-bell"></i>
                                    @if ($unreadCount > 0)
                                        <span
                                            class="absolute top-0 right-0 h-5 w-5 bg-red-500 rounded-full border-2 border-white flex items-center justify-center">
                                            <span
                                                class="text-xs text-white font-bold">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
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

                <!-- Main Content Area -->
                <div class="flex-1 p-6 overflow-y-auto">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Prospects Table -->
                    <div class="bg-white rounded-xl shadow-card overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Branch
                                        </th>

                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            supprimer
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($users as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">id##{{ $user->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->email }}</div>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->branch->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->name }}</div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                {{-- <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button> --}}
                                                {{-- <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button> --}}
                                                <!-- Bouton de suppression -->
                                                <button class="text-red-600 hover:text-red-900"
                                                    onclick="openConfirmModal({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <div id="confirmModal"
                                                    class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50"
                                                    style="backdrop-filter: blur(2px);">
                                                    <div
                                                        class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 border border-gray-100">
                                                        <!-- Header -->
                                                        <div class="px-6 py-5 border-b border-gray-200">
                                                            <div class="flex items-center">
                                                                <div
                                                                    class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center mr-3">
                                                                    <svg class="w-5 h-5 text-red-500" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                                <h3 class="text-xl font-semibold text-gray-900">Confirmation
                                                                    de suppression</h3>
                                                            </div>
                                                        </div>

                                                        <!-- Content -->
                                                        <div class="px-6 py-5 w-full overflow-hidden">
                                                            <p class="text-gray-800 text-sm font-medium leading-relaxed break-words whitespace-normal"
                                                                id="confirmMessage">
                                                                Êtes-vous sûr de vouloir supprimer ?
                                                            </p>
                                                        </div>


                                                        <!-- Actions -->
                                                        <div
                                                            class="px-6 py-4 bg-gray-50 rounded-b-xl flex justify-end space-x-3">
                                                            <button
                                                                class="px-5  text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-200"
                                                                onclick="closeConfirmModal()">
                                                                Annuler
                                                            </button>
                                                            <form id="deleteForm" method="POST" style="display:inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-200 shadow-sm hover:shadow-md">
                                                                    Supprimer
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            <div class="flex justify-center">
                                {{ $users->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('page.button-loading')
    </body>
@endsection

</html>
<script>
    function openConfirmModal(userId, userName) {
        const modal = document.getElementById('confirmModal');
        const message = document.getElementById('confirmMessage');
        const form = document.getElementById('deleteForm');

        message.textContent = `Êtes-vous sûr de vouloir supprimer "${userName}" ?`;
        form.action = `/users/${userId}`;
        modal.classList.remove('hidden');
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        modal.classList.add('hidden');
    }
</script>
