@extends('panel.layouts.app')

@section('content')
<div class="desk-header">
    <div class="desk-title">
        <i class="fas fa-gavel"></i>
        <span>
            @if(isset($project))
                Legal Desk: {{ $project->name }}
            @else
                Legal Desk
            @endif
        </span>
    </div>
    <div class="button-group">
        @if(isset($project))
            <a href="{{ route('projects.show', $project->id) }}" class="back-button mr-2">Back to Project</a>
        @endif
        <a href="{{ route('dashboard') }}" class="back-button">Back to NEPL Desk</a>
    </div>
</div>

<!-- Project Info Section (if a project is selected) -->
@if(isset($project))
<div class="project-info-box">
    <div class="project-info-header">
        <h3>Project Information</h3>
    </div>
    <div class="project-info-content">
        <div class="info-row">
            <div class="info-label">Project Name:</div>
            <div class="info-value">{{ $project->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Contract Number:</div>
            <div class="info-value">{{ $project->contract_number ?: 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Location:</div>
            <div class="info-value">{{ $project->location ?: 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">
                <span class="status-badge status-{{ $project->status }}">{{ ucfirst($project->status) }}</span>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Summary Section -->
<div class="section-title">Document Summary</div>

<!-- Filters -->
<form id="filter-form" action="{{ route('legal-desk.filter') }}" method="get">
    @csrf
    <div class="filters">
        <div class="filter">
            <div class="filter-label">Location</div>
            <select name="location" class="filter-value">
                <option value="">Pick Location</option>
                @foreach($locations as $location)
                    <option value="{{ $location }}" {{ isset($project) && $project->location == $location ? 'selected' : '' }}>{{ $location }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter">
            <div class="filter-label">Work Period From</div>
            <input type="date" name="from_date" class="filter-value" placeholder="Choose a Date">
        </div>
        <div class="filter">
            <div class="filter-label">Work Period To</div>
            <input type="date" name="to_date" class="filter-value" placeholder="Choose a Date">
        </div>
        <div class="filter">
            <div class="filter-label">Contract No</div>
            <select name="contract_id" class="filter-value">
                <option value="">Choose Contract</option>
                @foreach($contracts as $id => $contract)
                    <option value="{{ $id }}" {{ isset($projectId) && $projectId == $id ? 'selected' : '' }}>{{ $contract }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="search-btn">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>



<!-- Summary Table -->
<div class="summary-table">
    <table>
        <thead>
            <tr>
                <th></th>
                @foreach($documentTypes as $type)
                    <th>{{ $type->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Application Date</td>
                @foreach($documentTypes as $type)
                    <td class="date-cell {{ isset($summaryData[$type->id]) && $summaryData[$type->id]['status'] === 'expired' ? 'expired' : '' }}">
                        {{ isset($summaryData[$type->id]) ? $summaryData[$type->id]['application_date'] : '-' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>Issue Date</td>
                @foreach($documentTypes as $type)
                    <td class="date-cell {{ isset($summaryData[$type->id]) && $summaryData[$type->id]['status'] === 'expired' ? 'expired' : '' }}">
                        {{ isset($summaryData[$type->id]) ? $summaryData[$type->id]['issue_date'] : '-' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>Validity Date</td>
                @foreach($documentTypes as $type)
                    <td class="date-cell {{ isset($summaryData[$type->id]) && $summaryData[$type->id]['status'] === 'expired' ? 'expired' : (isset($summaryData[$type->id]) && $summaryData[$type->id]['status'] === 'upcoming_expiry' ? 'upcoming-expiry' : '') }}">
                        {{ isset($summaryData[$type->id]) ? $summaryData[$type->id]['validity_date'] : '-' }}
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>Days Remaining</td>
                @foreach($documentTypes as $type)
                    <td class="days-cell 
                        {{ isset($summaryData[$type->id]) && $summaryData[$type->id]['days_until_expiry'] !== null ? 
                            ($summaryData[$type->id]['days_until_expiry'] < 0 ? 'expired' : 
                                ($summaryData[$type->id]['days_until_expiry'] <= 30 ? 'upcoming-expiry' : '')) 
                            : '' 
                        }}">
                        @if(isset($summaryData[$type->id]) && $summaryData[$type->id]['days_until_expiry'] !== null)
                            @if($summaryData[$type->id]['days_until_expiry'] < 0)
                                Expired ({{ abs($summaryData[$type->id]['days_until_expiry']) }} days ago)
                            @else
                                {{ $summaryData[$type->id]['days_until_expiry'] }} days
                            @endif
                        @else
                            -
                        @endif
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

<!-- Notifications Section -->
<div class="section-title">Notifications</div>
<div class="notifications">
    <div class="notification-tabs">
        <a href="{{ route('legal-notifications.index', ['filter' => 'unread', 'project_id' => $projectId ?? null]) }}" class="notification-tab {{ $unreadCount > 0 ? 'active' : '' }}">
            Unread <span class="notification-badge">{{ $unreadCount }}</span>
        </a>
        <a href="{{ route('legal-notifications.index', ['filter' => 'read', 'project_id' => $projectId ?? null]) }}" class="notification-tab {{ $unreadCount === 0 ? 'active' : '' }}">
            Read <span class="notification-badge read">{{ $readCount }}</span>
        </a>
    </div>
    
    <div class="notification-list">
        @if($unreadNotifications->count() > 0)
            @foreach($unreadNotifications as $notification)
                <div class="notification-item" data-id="{{ $notification->id }}">
                    <div class="notification-content">
                        <i class="fas fa-bell notification-icon"></i>
                        <div class="notification-text">{{ $notification->message }}</div>
                    </div>
                    <div class="notification-actions">
                        <a href="{{ route('project-legal-documents.show', $notification->projectLegalDocument->id) }}" class="notification-btn read-more-btn">Read more</a>
                        <button class="notification-btn dismiss-btn" data-id="{{ $notification->id }}">Dismiss</button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-notifications">
                <p>No unread notifications.</p>
            </div>
        @endif
        
        @if($unreadNotifications->count() > 0 && $unreadCount > 4)
            <div class="view-all">
                <a href="{{ route('legal-notifications.index', ['project_id' => $projectId ?? null]) }}" class="view-all-link">View all notifications</a>
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

    .button-group {
        display: flex;
        gap: 10px;
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

    .project-info-box {
        background-color: #f9f9f9;
        border-radius: 6px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .project-info-header {
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }

    .project-info-header h3 {
        margin: 0;
        font-size: 16px;
        color: #333;
    }

    .project-info-content {
        padding: 15px 20px;
    }

    .info-row {
        display: flex;
        margin-bottom: 10px;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        width: 150px;
        font-weight: 500;
        color: #666;
    }

    .info-value {
        flex: 1;
        color: #333;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-active {
        background-color: #e6f7e6;
        color: #28a745;
    }

    .status-pending {
        background-color: #fff8e1;
        color: #ffc107;
    }

    .status-completed {
        background-color: #e6f0ff;
        color: #007bff;
    }

    .status-cancelled {
        background-color: #ffe6e6;
        color: #dc3545;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        margin: 25px 0 15px;
        padding-bottom: 5px;
        border-bottom: 1px solid #eee;
    }

    .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .filter {
        flex: 1;
        min-width: 200px;
    }

    .filter-label {
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }

    .filter-value {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: white;
    }

    .search-btn {
        align-self: flex-end;
        background-color: #e31e24;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        height: 38px;
    }

    .summary-table {
        width: 100%;
        overflow-x: auto;
        margin-bottom: 30px;
    }

    .summary-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .summary-table th, .summary-table td {
        border: 1px solid #ddd;
        padding: 12px 15px;
        text-align: center;
    }

    .summary-table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    .date-cell, .days-cell {
        font-weight: 500;
    }

    .date-cell.expired, .days-cell.expired {
        color: #e31e24;
    }

    .date-cell.upcoming-expiry, .days-cell.upcoming-expiry {
        color: #ff9800;
    }

    .notification-tabs {
        display: flex;
        margin-bottom: 15px;
        border-bottom: 1px solid #ddd;
    }

    .notification-tab {
        padding: 10px 20px;
        cursor: pointer;
        position: relative;
        color: #555;
        text-decoration: none;
    }

    .notification-tab.active {
        color: #e31e24;
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
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .notification-item {
        display: flex;
        flex-direction: column;
        background-color: #f9f9f9;
        border-radius: 4px;
        padding: 15px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .notification-content {
        display: flex;
        margin-bottom: 15px;
    }

    .notification-icon {
        color: #e31e24;
        font-size: 18px;
        margin-right: 15px;
    }

    .notification-text {
        flex: 1;
    }

    .notification-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .notification-btn {
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
    }

    .read-more-btn {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
    }

    .dismiss-btn {
        background-color: transparent;
        color: #e31e24;
        border: 1px solid #e31e24;
    }

    .no-notifications {
        padding: 20px;
        text-align: center;
        color: #777;
    }

    .view-all {
        text-align: center;
        margin-top: 15px;
    }

    .view-all-link {
        color: #e31e24;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .filters {
            flex-direction: column;
        }
        
        .filter {
            width: 100%;
        }
        
        .search-btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter form submission
        const filterForm = document.getElementById('filter-forms');
        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(filterForm);
                
                // Validate if at least one filter is selected
                let hasFilters = false;
                for (const [key, value] of formData.entries()) {
                    if (value && key !== '_token') {
                        hasFilters = true;
                        break;
                    }
                }
                
                if (!hasFilters) {
                    alert('Please select at least one filter to search.');
                    return;
                }
                
                // Show loading state
                document.querySelector('.search-btn').disabled = true;
                document.querySelector('.search-btn').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                
                fetch(filterForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // Reset search button
                    document.querySelector('.search-btn').disabled = false;
                    document.querySelector('.search-btn').innerHTML = '<i class="fas fa-search"></i>';
                    
                    if (data.success) {
                        // If message exists, show a no data placeholder
                        if (data.message) {
                            // Remove existing table if any
                            const existingTable = document.querySelector('.summary-table');
                            if (existingTable) {
                                existingTable.remove();
                            }
                            
                            // Create or update no-data message
                            let noDataMsg = document.querySelector('.no-data-message');
                            if (!noDataMsg) {
                                noDataMsg = document.createElement('div');
                                noDataMsg.className = 'no-data-message';
                                
                                // Insert before notifications section
                                const notificationsSection = document.querySelector('.section-title:nth-of-type(2)');
                                notificationsSection.parentNode.insertBefore(noDataMsg, notificationsSection);
                            }
                            
                            noDataMsg.innerHTML = `
                                <i class="fas fa-filter"></i>
                                <p>${data.message}</p>
                            `;
                            
                            // Remove any project info display
                            const existingProjectInfo = document.querySelector('.selected-project-info');
                            if (existingProjectInfo) {
                                existingProjectInfo.remove();
                            }
                            
                            return;
                        }
                        
                        // Check if summary data is empty
                        if (Object.keys(data.summaryData).length === 0) {
                            // Remove existing table if any
                            const existingTable = document.querySelector('.summary-table');
                            if (existingTable) {
                                existingTable.remove();
                            }
                            
                            // Create or update no-data message
                            let noDataMsg = document.querySelector('.no-data-message');
                            if (!noDataMsg) {
                                noDataMsg = document.createElement('div');
                                noDataMsg.className = 'no-data-message';
                                
                                // Insert before notifications section
                                const notificationsSection = document.querySelector('.section-title:nth-of-type(2)');
                                notificationsSection.parentNode.insertBefore(noDataMsg, notificationsSection);
                            }
                            
                            noDataMsg.innerHTML = `
                                <i class="fas fa-search"></i>
                                <p>No legal documents found for the selected filters.</p>
                            `;
                            
                            return;
                        }
                        
                        // Show project info if available
                        if (data.project) {
                            let projectInfoHTML = `
                                <div class="selected-project-info">
                                    <div class="project-info-label">Selected Contract:</div>
                                    <div class="project-info-value">${data.project.contract_number} (${data.project.name})</div>
                                </div>
                            `;
                            
                            // Update or create project info
                            const existingProjectInfo = document.querySelector('.selected-project-info');
                            if (existingProjectInfo) {
                                existingProjectInfo.outerHTML = projectInfoHTML;
                            } else {
                                const filterForm = document.getElementById('filter-form');
                                const newProjectInfo = document.createElement('div');
                                newProjectInfo.innerHTML = projectInfoHTML;
                                filterForm.parentNode.insertBefore(newProjectInfo.firstElementChild, filterForm.nextSibling);
                            }
                        } else {
                            // Remove any project info if not available
                            const existingProjectInfo = document.querySelector('.selected-project-info');
                            if (existingProjectInfo) {
                                existingProjectInfo.remove();
                            }
                        }
                        
                        // Remove any no-data message
                        const noDataMsg = document.querySelector('.no-data-message');
                        if (noDataMsg) {
                            noDataMsg.remove();
                        }
                        
                        // Create or update summary table
                        const documentTypeIds = Object.keys(data.summaryData);
                        
                        let tableHTML = `
                            <div class="summary-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <td></td>
                                            ${documentTypeIds.map(typeId => 
                                                `<th>${data.summaryData[typeId].name}</th>`
                                            ).join('')}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Application Date</td>
                                            ${documentTypeIds.map(typeId => 
                                                `<td class="date-cell ${data.summaryData[typeId].status === 'expired' ? 'expired' : ''}">${data.summaryData[typeId].application_date || '-'}</td>`
                                            ).join('')}
                                        </tr>
                                        <tr>
                                            <td>Issue Date</td>
                                            ${documentTypeIds.map(typeId => 
                                                `<td class="date-cell ${data.summaryData[typeId].status === 'expired' ? 'expired' : ''}">${data.summaryData[typeId].issue_date || '-'}</td>`
                                            ).join('')}
                                        </tr>
                                        <tr>
                                            <td>Validity Date</td>
                                            ${documentTypeIds.map(typeId => {
                                                const status = data.summaryData[typeId].status;
                                                const statusClass = status === 'expired' ? 'expired' : (status === 'upcoming_expiry' ? 'upcoming-expiry' : '');
                                                return `<td class="date-cell ${statusClass}">${data.summaryData[typeId].validity_date || '-'}</td>`;
                                            }).join('')}
                                        </tr>
                                        <tr>
                                            <td>Days Remaining</td>
                                            ${documentTypeIds.map(typeId => {
                                                const daysUntilExpiry = data.summaryData[typeId].days_until_expiry;
                                                let content = '-';
                                                let statusClass = '';
                                                
                                                if (daysUntilExpiry !== null) {
                                                    if (daysUntilExpiry < 0) {
                                                        content = `Expired`;
                                                        statusClass = 'expired';
                                                    } else {
                                                        content = `${daysUntilExpiry} days`;
                                                        if (daysUntilExpiry <= 30) {
                                                            statusClass = 'upcoming-expiry';
                                                        }
                                                    }
                                                }
                                                
                                                return `<td class="days-cell ${statusClass}">${content}</td>`;
                                            }).join('')}
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        `;
                        
                        // Update or create table
                        const existingTable = document.querySelector('.summary-table');
                        if (existingTable) {
                            existingTable.outerHTML = tableHTML;
                        } else {
                            // Find where to insert the table (before notifications section)
                            const notificationsSection = document.querySelector('.section-title:nth-of-type(2)');
                            const tableContainer = document.createElement('div');
                            tableContainer.innerHTML = tableHTML;
                            notificationsSection.parentNode.insertBefore(tableContainer.firstElementChild, notificationsSection);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reset search button
                    document.querySelector('.search-btn').disabled = false;
                    document.querySelector('.search-btn').innerHTML = '<i class="fas fa-search"></i>';
                    alert('An error occurred while fetching data. Please try again.');
                });
            });
        }
        
        // Notification tabs functionality
        const notificationTabs = document.querySelectorAll('.notification-tab');
        notificationTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                const tabName = this.getAttribute('data-tab');
                
                // Update active tab
                notificationTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Show the corresponding tab content
                document.querySelectorAll('.notification-list').forEach(list => {
                    list.classList.add('hidden');
                });
                document.getElementById(`${tabName}-tab`).classList.remove('hidden');
            });
        });
        
        // Dismiss notification
        const dismissButtons = document.querySelectorAll('.dismiss-btn');
        dismissButtons.forEach(button => {
            button.addEventListener('click', function() {
                const notificationId = this.getAttribute('data-id');
                const notificationItem = this.closest('.notification-item');
                
                // Show loading state
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                this.disabled = true;
                
                fetch(`{{ url('legal-notifications/dismiss') }}/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the notification from the list
                        notificationItem.remove();
                        
                        // Update unread count
                        const unreadBadge = document.querySelector('.notification-tab[data-tab="unread"] .notification-badge');
                        if (unreadBadge) {
                            const currentCount = parseInt(unreadBadge.textContent);
                            unreadBadge.textContent = currentCount - 1;
                        }
                        
                        // Update read count
                        const readBadge = document.querySelector('.notification-tab[data-tab="read"] .notification-badge');
                        if (readBadge) {
                            const currentReadCount = parseInt(readBadge.textContent);
                            readBadge.textContent = currentReadCount + 1;
                        }
                        
                        // Check if no notifications left
                        const notificationItems = document.querySelectorAll('.notification-item');
                        if (notificationItems.length === 0) {
                            const notificationList = document.querySelector('#unread-tab');
                            notificationList.innerHTML = `
                                <div class="no-notifications">
                                    <p>No unread notifications.</p>
                                </div>
                            `;
                        }
                    } else {
                        // Reset button state
                        this.innerHTML = 'Dismiss';
                        this.disabled = false;
                        alert('Failed to dismiss notification. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reset button state
                    this.innerHTML = 'Dismiss';
                    this.disabled = false;
                    alert('An error occurred while dismissing the notification. Please try again.');
                });
            });
        });
    });
</script>

@endsection