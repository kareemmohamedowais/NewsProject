<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function getNotifications()
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return apiResponse(401, 'Unauthenticated');
    }

    return apiResponse(200, 'User notifications', [
        'notifications'        => NotificationResource::collection($user->notifications()->latest()->get()),
        'unread_notifications' => NotificationResource::collection($user->unreadNotifications()->latest()->get()),
    ]);
}

public function readNotification($id)
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return apiResponse(401, 'Unauthenticated');
    }

    $notification = $user->unreadNotifications()->find($id);

    if (!$notification) {
        return apiResponse(404, 'Notification not found');
    }

    $notification->markAsRead();

    return apiResponse(200, 'Notification marked as read');
}

public function deleteNotification($id)
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return apiResponse(401, 'Unauthenticated');
    }

    $notification = $user->notifications()->find($id);

    if (!$notification) {
        return apiResponse(404, 'Notification not found');
    }

    $notification->delete();

    return apiResponse(200, 'Notification deleted successfully');
}

public function deleteAllNotifications()
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return apiResponse(401, 'Unauthenticated');
    }

    $user->notifications()->delete();

    return apiResponse(200, 'All notifications deleted successfully');
}
public function markAllAsRead()
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return apiResponse(401, 'Unauthenticated');
    }

    if ($user->unreadNotifications()->count() === 0) {
        return apiResponse(200, 'No unread notifications');
    }

    $user->unreadNotifications->markAsRead();

    return apiResponse(200, 'All notifications marked as read');
}


}
