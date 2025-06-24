{{-- resources/views/notifications/index.blade.php --}}
@extends('layouts.mastere')

@section('title', 'Notifications - Tableau de Bord')

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
                            <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
                            <p class="text-sm text-gray-500">Restez informé des activités importantes</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative"
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
                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md"
                            id="successMessage">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md"
                            id="errorMessage">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 sm:gap-0">
                        <h2 class="text-lg font-semibold">
                            Notifications
                            @if ($unreadCount > 0)
                                <span class="text-red-500">({{ $unreadCount }} non lues)</span>
                            @endif
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @if ($unreadCount > 0)
                                <button id="markAllRead"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Tout marquer comme lu
                                </button>
                            @endif
                            <button
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                onclick="window.location.reload()">
                                <i class="fas fa-sync mr-2"></i>
                                Actualiser
                            </button>
                        </div>
                    </div>

                    <!-- Filter options -->
                    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-200">
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('notifications.index') }}"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md {{ $type === 'all' ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                                <i class="fas fa-check-circle mr-1.5"></i>
                                Tous ({{ $counts['all'] }})
                            </a>

                            <a href="{{ route('notifications.index', ['type' => 'client']) }}"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md {{ $type === 'client' ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                                <i class="fas fa-user-plus mr-1.5 text-blue-500"></i>
                                Clients ({{ $counts['client'] }})
                            </a>

                            <a href="{{ route('notifications.index', ['type' => 'invoice']) }}"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md {{ $type === 'invoice' ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50' }}">
                                <i class="fas fa-file-invoice-dollar mr-1.5 text-green-500"></i>
                                Factures ({{ $counts['invoice'] }})
                            </a>
                        </div>
                    </div>

                    <!-- Notifications List -->
                    @if ($notifications->count() > 0)
                        <div class="space-y-4" id="notificationsList">
                            @foreach ($notifications as $notification)
                                <div class="notification-item {{ $notification->bg_class }} rounded-xl shadow-sm p-4 border transition-all duration-200"
                                    data-id="{{ $notification->id }}"
                                    data-read="{{ $notification->is_read ? 'true' : 'false' }}">
                                    <div class="flex flex-col sm:flex-row">
                                        <div class="mb-3 sm:mb-0 sm:mr-4">
                                            <div
                                                class="h-12 w-12 rounded-full bg-white shadow-sm flex items-center justify-center {{ $notification->color_class }}">
                                                <i class="{{ $notification->icon }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2">
                                                <h4 class="font-medium text-gray-900 flex items-center">
                                                    {{ $notification->title }}
                                                    @if (!$notification->is_read)
                                                        <span
                                                            class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            Nouveau
                                                        </span>
                                                    @endif
                                                </h4>
                                                <span class="text-xs text-gray-500 mt-1 sm:mt-0">
                                                    {{ $notification->time_ago }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-3">{{ $notification->content }}</p>

                                            @if ($notification->creator)
                                                <p class="text-xs text-gray-500 mb-3">
                                                    <i class="fas fa-user mr-1"></i>
                                                    Par {{ $notification->creator->name }}
                                                </p>
                                            @endif

                                            <div class="flex flex-wrap gap-2">
                                                @if (!$notification->is_read)
                                                    <button
                                                        class="mark-as-read inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                                        data-id="{{ $notification->id }}">
                                                        <i class="fas fa-check mr-1.5"></i>
                                                        Marquer comme lu
                                                    </button>
                                                @endif

                                                <button
                                                    class="delete-notification inline-flex items-center px-3 py-1.5 border border-red-300 shadow-sm text-xs font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                    data-id="{{ $notification->id }}">
                                                    <i class="fas fa-trash mr-1.5"></i>
                                                    Supprimer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="confirm-modal"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
                                <h3 class="text-lg font-semibold mb-4">Êtes-vous sûr de vouloir supprimer cette notification
                                    ?</h3>
                                <div class="flex justify-center gap-4">
                                    <button id="confirm-yes"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">OUI</button>
                                    <button id="confirm-no"
                                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">NON</button>
                                </div>
                            </div>
                        </div>



                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $notifications->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto h-12 w-12 text-gray-400">
                                <i class="fas fa-bell-slash text-4xl"></i>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune notification</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if ($type !== 'all')
                                    Aucune notification de ce type pour le moment.
                                @else
                                    Vous n'avez aucune notification pour le moment.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @include('page.button-loading')

        <!-- JavaScript for AJAX functionality -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // CSRF token for AJAX requests
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Mark single notification as read
                document.querySelectorAll('.mark-as-read').forEach(button => {
                    button.addEventListener('click', function() {
                        const notificationId = this.getAttribute('data-id');
                        markAsRead(notificationId, this);
                    });
                });

                // Mark all notifications as read
                const markAllReadBtn = document.getElementById('markAllRead');
                if (markAllReadBtn) {
                    markAllReadBtn.addEventListener('click', function() {
                        markAllAsRead();
                    });
                }

                const modal = document.getElementById('confirm-modal');
                const btnYes = document.getElementById('confirm-yes');
                const btnNo = document.getElementById('confirm-no');

                let currentNotificationId = null;
                let currentButton = null;

                document.querySelectorAll('.delete-notification').forEach(button => {
                    button.addEventListener('click', function() {
                        currentNotificationId = this.getAttribute('data-id');
                        currentButton = this;
                        modal.classList.remove('hidden');
                    });
                });

                btnYes.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    deleteNotification(currentNotificationId, currentButton);
                });

                btnNo.addEventListener('click', function() {
                    modal.classList.add('hidden');
                });


                // Auto-hide success/error messages
                setTimeout(() => {
                    const successMsg = document.getElementById('successMessage');
                    const errorMsg = document.getElementById('errorMessage');
                    if (successMsg) successMsg.style.display = 'none';
                    if (errorMsg) errorMsg.style.display = 'none';
                }, 5000);

                function markAsRead(notificationId, button) {
                    fetch(`/notifications/${notificationId}/read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update UI
                                const notificationItem = button.closest('.notification-item');
                                notificationItem.setAttribute('data-read', 'true');
                                notificationItem.className = notificationItem.className.replace(/bg-\w+-50/,
                                    'bg-white').replace(/border-\w+-100/, 'border-gray-200');

                                // Remove "Nouveau" badge
                                const newBadge = notificationItem.querySelector('.bg-blue-100');
                                if (newBadge) newBadge.remove();

                                // Remove the button
                                button.remove();

                                // Update counter
                                updateNotificationCounter();

                                showMessage(data.message, 'success');
                            } else {
                                showMessage(data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showMessage('Une erreur est survenue', 'error');
                        });
                }

                function markAllAsRead() {
                    fetch('/notifications/read-all', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Reload page to update UI
                                window.location.reload();
                            } else {
                                showMessage(data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showMessage('Une erreur est survenue', 'error');
                        });
                }

                function deleteNotification(notificationId, button) {
                    fetch(`/notifications/${notificationId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove notification from UI
                                const notificationItem = button.closest('.notification-item');
                                notificationItem.style.transition = 'all 0.3s ease';
                                notificationItem.style.opacity = '0';
                                notificationItem.style.transform = 'translateX(-100%)';

                                setTimeout(() => {
                                    notificationItem.remove();
                                    updateNotificationCounter();

                                    // Check if no notifications left
                                    if (document.querySelectorAll('.notification-item').length === 0) {
                                        window.location.reload();
                                    }
                                }, 300);

                                showMessage(data.message, 'success');
                            } else {
                                showMessage(data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showMessage('Une erreur est survenue', 'error');
                        });
                }

                function updateNotificationCounter() {
                    fetch('/notifications/unread-count')
                        .then(response => response.json())
                        .then(data => {
                            const bell = document.getElementById('notificationBell');
                            const badge = bell.querySelector('span');

                            if (data.count > 0) {
                                if (!badge) {
                                    const newBadge = document.createElement('span');
                                    newBadge.className =
                                        'absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full border-2 border-white flex items-center justify-center';
                                    newBadge.innerHTML =
                                        `<span class="text-xs text-white font-bold">${data.count > 9 ? '9+' : data.count}</span>`;
                                    bell.appendChild(newBadge);
                                } else {
                                    badge.querySelector('span').textContent = data.count > 9 ? '9+' : data.count;
                                }
                            } else {
                                if (badge) {
                                    badge.remove();
                                }
                            }
                        });
                }

                function showMessage(message, type) {
                    // Create message element
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-md shadow-lg ${
                type === 'success'
                ? 'bg-green-50 border border-green-200 text-green-800'
                : 'bg-red-50 border border-red-200 text-red-800'
            }`;
                    messageDiv.textContent = message;

                    document.body.appendChild(messageDiv);

                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        messageDiv.style.opacity = '0';
                        setTimeout(() => {
                            if (messageDiv.parentNode) {
                                messageDiv.parentNode.removeChild(messageDiv);
                            }
                        }, 300);
                    }, 3000);
                }
            });
        </script>
    </body>
@endsection
