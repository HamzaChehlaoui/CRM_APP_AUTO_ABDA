<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get filter type
        $type = $request->get('type', 'all');

        // Only allow 'all', 'client', or 'invoice' as filter types
        if (!in_array($type, ['all', 'client', 'invoice'])) {
            $type = 'all';
        }

        // Build query
        $query = $user->notifications()->latest();

        if ($type !== 'all') {
            $query->byType($type);
        }

        $notifications = $query->paginate(50);

        // Get counts (only for client and invoice)
        $unreadCount = $user->notifications()->unread()->count();
        $counts = [
            'all' => $user->notifications()->count(),
            'client' => $user->notifications()->byType('client')->count(),
            'invoice' => $user->notifications()->byType('invoice')->count(),
        ];

        return view('page.notifications', compact('notifications', 'unreadCount', 'counts', 'type'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->user_id == Auth::id()) {
            $notification->markAsRead();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Notification marquée comme lue'
                ]);
            }

            return redirect()->back()->with('success', 'Notification marquée comme lue.');
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Notification non trouvée'
            ], 404);
        }

        return redirect()->back()->with('error', 'Notification non trouvée.');
    }

    public function markAllAsRead()
    {
        $user = Auth::user();

        $user->notifications()->unread()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Toutes les notifications marquées comme lues'
            ]);
        }

        return redirect()->back()->with('success', 'Toutes les notifications marquées comme lues.');
    }

    public function getUnreadCount()
    {
        $count = Auth::user()->notifications()->unread()->count();

        return response()->json(['count' => $count]);
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->user_id == Auth::id()) {
            $notification->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Notification supprimée'
                ]);
            }

            return redirect()->back()->with('success', 'Notification supprimée.');
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Notification non trouvée'
            ], 404);
        }

        return redirect()->back()->with('error', 'Notification non trouvée.');
    }

    // Static method to create notifications
    public static function createNotification($userId, $title, $content, $type = 'info', $creatorId = null, $data = null)
    {
        $notifications = [];
        $notifiedUserIds = [];

        // Create notification for the original user
        $notifications[] = Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'content' => $content,
            'type' => $type,
            'created_by' => $creatorId ?? Auth::id(),
            'data' => $data,
            'is_read' => false,
        ]);
        $notifiedUserIds[] = $userId;

        // Get all admin and assistant users
        $adminUsers = \App\Models\User::whereIn('role_id', [1, 2])->get();

        // Create notifications for admins and assistants (if they haven't received it yet)
        foreach ($adminUsers as $admin) {
            if (!in_array($admin->id, $notifiedUserIds)) {
                $notifications[] = Notification::create([
                    'user_id' => $admin->id,
                    'title' => $title,
                    'content' => $content,
                    'type' => $type,
                    'created_by' => $creatorId ?? Auth::id(),
                    'data' => $data,
                    'is_read' => false,
                ]);
                $notifiedUserIds[] = $admin->id;
            }
        }

        return $notifications;
    }
}



