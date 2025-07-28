<?php

namespace App\Http\Controllers;

use App\Models\LegalNotification;
use Illuminate\Http\Request;

class LegalNotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Default to showing unread notifications
        $filter = $request->filter ?? 'unread';
        
        if ($filter === 'read') {
            $notifications = LegalNotification::read()->with('projectLegalDocument.legalDocumentType')->latest()->paginate(10);
        } else {
            $notifications = LegalNotification::unread()->with('projectLegalDocument.legalDocumentType')->latest()->paginate(10);
        }
        
        $unreadCount = LegalNotification::unread()->count();
        $readCount = LegalNotification::read()->count();
        
        return view('panel.legal-notifications.index', compact('notifications', 'filter', 'unreadCount', 'readCount'));
    }

    /**
     * Mark notification as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        $notification = LegalNotification::findOrFail($id);
        $notification->markAsRead();
        
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Dismiss notification (mark as read).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dismiss($id)
    {
        $notification = LegalNotification::findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }
}
