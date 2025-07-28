<!-- resources/views/legal-notifications/index.blade.php -->

@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-bell"></i>
        <span>Legal Notifications</span>
    </div>
    <a href="{{ route('legal-desk.index') }}" class="back-button">Back to Legal Desk</a>
</div>

<!-- Notifications Section -->
<div class="notifications-container">
    <div class="notification-tabs">
        <a href="{{ route('legal-notifications.index', ['filter' => 'unread']) }}" class="notification-tab {{ $filter === 'unread' ? 'active' : '' }}">
            Unread <span class="notification-badge">{{ $unreadCount }}</span>
        </a>
        <a href="{{ route('legal-notifications.index', ['filter' => 'read']) }}" class="notification-tab {{ $filter === 'read' ? 'active' : '' }}">
            Read <span class="notification-badge read">{{ $readCount }}</span>
        </a>
    </div>
    
    <div class="notification-list">
        @if($notifications->count() > 0)
            @foreach($notifications as $notification)
                <div class="notification-item" data-id="{{ $notification->id }}">
                    <div class="notification-header">
                        <div class="notification-title">
                            <i class="fas fa-bell notification-icon"></i>
                            <span>{{ $notification->title }}</span>
                        </div>
                        <div class="notification-date">
                            {{ $notification->notification_date->format('d M Y, h:i A') }}
                        </div>
                    </div>
                    <div class="notification-content">
                        <div class="notification-text">{{ $notification->message }}</div>
                        <div class="notification-document">
                            <strong>Document:</strong> {{ $notification->projectLegalDocument->legalDocumentType->name }}
                            <br>
                            <strong>Project:</strong> {{ $notification->projectLegalDocument->project->name }}
                        </div>
                    </div>
                    <div class="notification-actions">
                        <a href="{{ route('project-legal-documents.show', $notification->projectLegalDocument->id) }}" class="notification-btn view-btn">
                            <i class="fas fa-eye"></i> View Document
                        </a>
                        @if($filter === 'unread')
                            <button class="notification-btn mark-read-btn" data-id="{{ $notification->id }}">
                                <i class="fas fa-check"></i> Mark as Read
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
            
            <div class="pagination-container">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="no-notifications">
                <p>No {{ $filter }} notifications found.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .desk-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .desk-title {
        display: flex;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
    }

    .desk-title i {
        font-size: 24px;
        margin-right: 10px;
        color: #e31e24;
    }

    .back-button {
        background-color: #f0f0f0;
        color: #333;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .back-button:hover {
        background-color: #e0e0e0;
    }

    .notifications-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .notification-tabs {
        display: flex;
        background-color: #f5f5f5;
        border-bottom: 1px solid #ddd;
    }

    .notification-tab {
        padding: 15px 25px;
        cursor: pointer;
        position: relative;
        color: #555;
        text-decoration: none;
        font-weight: 500;
    }

    .notification-tab.active {
        color: #e31e24;
        background-color: white;
        border-bottom: 2px solid #e31e24;
    }

    .notification-badge {
        background-color: #e31e24;
        color: white;
        font-size: 12px;
        border-radius: 10px;
        padding: 2px 6px;
        margin-left: 5px;
    }

    .notification-badge.read {
        background-color: #999;
    }

    .notification-list {
        padding: 20px;
    }

    .notification-item {
        border: 1px solid #eee;
        border-radius: 6px;
        margin-bottom: 15px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .notification-item:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f9f9f9;
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }

    .notification-title {
        display: flex;
        align-items: center;
        font-weight: 600;
    }

    .notification-icon {
        color: #e31e24;
        margin-right: 10px;
    }

    .notification-date {
        font-size: 13px;
        color: #777;
    }

    .notification-content {
        padding: 15px;
        background-color: white;
    }

    .notification-text {
        margin-bottom: 10px;
    }

    .notification-document {
        font-size: 14px;
        color: #666;
        background-color: #f9f9f9;
        padding: 10px;
        border-radius: 4px;
    }

    .notification-actions {
        display: flex;
        padding: 10px 15px;
        background-color: #f5f5f5;
        border-top: 1px solid #eee;
    }

    .notification-btn {
        display: flex;
        align-items: center;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        margin-right: 10px;
        text-decoration: none;
        border: none;
    }

    .notification-btn i {
        margin-right: 5px;
    }

    .view-btn {
        background-color: #f0f0f0;
        color: #333;
    }

    .mark-read-btn {
        background-color: #e31e24;
        color: white;
    }

    .no-notifications {
        padding: 30px;
        text-align: center;
        color: #777;
    }

    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .notification-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .notification-date {
            margin-top: 5px;
            margin-left: 25px;
        }

        .notification-actions {
            flex-direction: column;
        }

        .notification-btn {
            margin-bottom: 5px;
            width: 100%;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark as Read functionality
        const markReadButtons = document.querySelectorAll('.mark-read-btn');
        markReadButtons.forEach(button => {
            button.addEventListener('click', function() {
                const notificationId = this.getAttribute('data-id');
                const notificationItem = this.closest('.notification-item');
                
                fetch(`{{ url('legal-notifications/mark-as-read') }}/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the notification from the list
                        notificationItem.remove();
                        
                        // Update unread count
                        const unreadBadge = document.querySelector('.notification-tab:first-child .notification-badge');
                        if (unreadBadge) {
                            const currentCount = parseInt(unreadBadge.textContent);
                            unreadBadge.textContent = Math.max(0, currentCount - 1);
                        }
                        
                        // Update read count
                        const readBadge = document.querySelector('.notification-tab:last-child .notification-badge');
                        if (readBadge) {
                            const currentReadCount = parseInt(readBadge.textContent);
                            readBadge.textContent = currentReadCount + 1;
                        }
                        
                        // Check if no notifications left
                        const notificationItems = document.querySelectorAll('.notification-item');
                        if (notificationItems.length === 0) {
                            const notificationList = document.querySelector('.notification-list');
                            notificationList.innerHTML = `
                                <div class="no-notifications">
                                    <p>No unread notifications found.</p>
                                </div>
                            `;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
@endsection