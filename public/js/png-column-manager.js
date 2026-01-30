/**
 * PNG Column Manager
 * Manages column visibility for Basic Information and Technical Information tables
 */

// Column definitions for both tables
const columnDefinitions = {
    basic: [
        { id: 'col-checkbox', name: 'Select', index: 0, locked: true },
        { id: 'col-actions', name: 'Actions', index: 1, locked: true },
        { id: 'col-agreement-date', name: 'Agreement Date', index: 2 },
        { id: 'col-customer-no', name: 'Customer No', index: 3 },
        { id: 'col-order-no', name: 'Order No', index: 4 },
        { id: 'col-application-no', name: 'Application No', index: 5 },
        { id: 'col-customer-name', name: 'Customer Name', index: 6 },
        { id: 'col-contact-no', name: 'Contact No', index: 7 },
        { id: 'col-address', name: 'Address', index: 8 },
        { id: 'col-area', name: 'Area', index: 9 },
        { id: 'col-scheme', name: 'Scheme', index: 10 },
        { id: 'col-sla-days', name: 'SLA Days', index: 11 }
    ],
    technical: [
        { id: 'col-connections-status', name: 'Connections Status', index: 0 },
        { id: 'col-plumber-name', name: 'Plumber Name', index: 1 },
        { id: 'col-plumbing-date', name: 'Plumbing Date', index: 2 },
        { id: 'col-ppt-date', name: 'PPT Date', index: 3 },
        { id: 'col-ppt-witness', name: 'PPT Witness By', index: 4 },
        { id: 'col-gc-date', name: 'Ground Connections Date', index: 5 },
        { id: 'col-gc-witness', name: 'Ground Connections Witness By', index: 6 },
        { id: 'col-mukkadam-name', name: 'Mukkadam Name', index: 7 },
        { id: 'col-mmt-date', name: 'MMT Date', index: 8 },
        { id: 'col-mmt-witness', name: 'MMT Witness By', index: 9 },
        { id: 'col-conversion-tech', name: 'Conversion Technician Name', index: 10 },
        { id: 'col-conversion-date', name: 'Conversion Date', index: 11 },
        { id: 'col-conversion-status', name: 'Conversion Status', index: 12 },
        { id: 'col-report-date', name: 'Report Submission Date', index: 13 },
        { id: 'col-meter-number', name: 'Meter Number', index: 14 },
        { id: 'col-ra-bill', name: 'RA-Bill No.', index: 15 },
        { id: 'col-remarks', name: 'Remarks', index: 16 }
    ]
};

// LocalStorage key
const STORAGE_KEY = 'png_column_visibility';

// Get column visibility from localStorage
function getColumnVisibility() {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored) {
        try {
            return JSON.parse(stored);
        } catch (e) {
            console.error('Error parsing column visibility:', e);
        }
    }
    
    // Default: all columns visible
    const defaults = {};
    columnDefinitions.basic.forEach(col => {
        defaults[col.id] = true;
    });
    columnDefinitions.technical.forEach(col => {
        defaults[col.id] = true;
    });
    return defaults;
}

// Save column visibility to localStorage
function saveColumnVisibility(visibility) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(visibility));
    console.log('Saved visibility:', visibility);
}

// Toggle column manager panel
function toggleColumnManager() {
    const panel = document.getElementById('column-manager-panel');
    if (panel.style.display === 'none' || panel.style.display === '') {
        panel.style.display = 'flex';
        // Close when clicking outside
        setTimeout(() => {
            document.addEventListener('click', closeOnClickOutside);
        }, 100);
    } else {
        panel.style.display = 'none';
        document.removeEventListener('click', closeOnClickOutside);
    }
}

// Close panel when clicking outside
function closeOnClickOutside(event) {
    const panel = document.getElementById('column-manager-panel');
    const wrapper = document.querySelector('.column-manager-wrapper');
    
    if (!wrapper.contains(event.target)) {
        panel.style.display = 'none';
        document.removeEventListener('click', closeOnClickOutside);
    }
}

// Initialize column manager UI
function initializeColumnManager() {
    const visibility = getColumnVisibility();
    
    // Populate Basic Information columns
    const basicList = document.getElementById('basic-columns-list');
    if (basicList) {
        basicList.innerHTML = '';
        columnDefinitions.basic.forEach(col => {
            const item = createColumnItem(col, visibility[col.id] !== false);
            basicList.appendChild(item);
        });
    }
    
    // Populate Technical Information columns
    const techList = document.getElementById('technical-columns-list');
    if (techList) {
        techList.innerHTML = '';
        columnDefinitions.technical.forEach(col => {
            const item = createColumnItem(col, visibility[col.id] !== false);
            techList.appendChild(item);
        });
    }
    
    // Apply current visibility
    applyColumnVisibility(visibility);
}

// Create column checkbox item
function createColumnItem(column, isVisible) {
    const div = document.createElement('div');
    div.className = 'column-item' + (column.locked ? ' disabled' : '');
    
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.id = `checkbox-${column.id}`;
    checkbox.checked = isVisible;
    checkbox.disabled = column.locked || false;
    checkbox.dataset.columnId = column.id;
    
    if (!column.locked) {
        checkbox.addEventListener('change', function() {
            console.log(`Toggling ${column.id} to ${this.checked}`);
            toggleColumn(column.id, this.checked);
        });
    }
    
    const label = document.createElement('label');
    label.htmlFor = `checkbox-${column.id}`;
    label.textContent = column.name + (column.locked ? ' (Required)' : '');
    
    div.appendChild(checkbox);
    div.appendChild(label);
    
    return div;
}

// Toggle single column visibility
function toggleColumn(columnId, isVisible) {
    const visibility = getColumnVisibility();
    visibility[columnId] = isVisible;
    saveColumnVisibility(visibility);
    applyColumnVisibility(visibility);
}

// Apply column visibility to tables
function applyColumnVisibility(visibility) {
    console.log('Applying visibility:', visibility);
    
    // Find all table sections
    const tableSections = document.querySelectorAll('.table-section');
    console.log(`Found ${tableSections.length} table sections`);
    
    // Apply to Basic Information table (first table section)
    let basicTable = null;
    tableSections.forEach((section, index) => {
        const title = section.querySelector('.table-section-title');
        if (title && title.textContent.includes('Basic Information')) {
            basicTable = section.querySelector('.data-table');
            console.log(`Found Basic Information table at index ${index}`);
        }
    });
    
    if (basicTable) {
        console.log('Processing basic table columns');
        columnDefinitions.basic.forEach(col => {
            const isVisible = visibility[col.id] !== false;
            const colIndex = col.index + 1; // CSS nth-child is 1-based
            
            // Select header and body cells
            const headerCells = basicTable.querySelectorAll(`thead tr th:nth-child(${colIndex})`);
            const bodyCells = basicTable.querySelectorAll(`tbody tr td:nth-child(${colIndex})`);
            
            console.log(`Column ${col.name} (index ${colIndex}): ${isVisible ? 'visible' : 'hidden'}, found ${headerCells.length} headers, ${bodyCells.length} body cells`);
            
            // Apply to headers
            headerCells.forEach(cell => {
                if (isVisible) {
                    cell.style.display = '';
                    cell.classList.remove('column-hidden');
                } else {
                    cell.style.display = 'none';
                    cell.classList.add('column-hidden');
                }
            });
            
            // Apply to body cells
            bodyCells.forEach(cell => {
                if (isVisible) {
                    cell.style.display = '';
                    cell.classList.remove('column-hidden');
                } else {
                    cell.style.display = 'none';
                    cell.classList.add('column-hidden');
                }
            });
        });
    } else {
        console.error('Basic Information table not found');
    }
    
    // Apply to Technical Information table
    let techTable = null;
    tableSections.forEach((section, index) => {
        const title = section.querySelector('.table-section-title');
        if (title && title.textContent.includes('Technical Information')) {
            techTable = section.querySelector('.data-table');
            console.log(`Found Technical Information table at index ${index}`);
        }
    });
    
    if (techTable) {
        console.log('Processing technical table columns');
        columnDefinitions.technical.forEach(col => {
            const isVisible = visibility[col.id] !== false;
            const colIndex = col.index + 1; // CSS nth-child is 1-based
            
            // Select header and body cells
            const headerCells = techTable.querySelectorAll(`thead tr th:nth-child(${colIndex})`);
            const bodyCells = techTable.querySelectorAll(`tbody tr td:nth-child(${colIndex})`);
            
            console.log(`Column ${col.name} (index ${colIndex}): ${isVisible ? 'visible' : 'hidden'}, found ${headerCells.length} headers, ${bodyCells.length} body cells`);
            
            // Apply to headers
            headerCells.forEach(cell => {
                if (isVisible) {
                    cell.style.display = '';
                    cell.classList.remove('column-hidden');
                } else {
                    cell.style.display = 'none';
                    cell.classList.add('column-hidden');
                }
            });
            
            // Apply to body cells
            bodyCells.forEach(cell => {
                if (isVisible) {
                    cell.style.display = '';
                    cell.classList.remove('column-hidden');
                } else {
                    cell.style.display = 'none';
                    cell.classList.add('column-hidden');
                }
            });
        });
    } else {
        console.error('Technical Information table not found');
    }
}

// Select all columns
function selectAllColumns() {
    const visibility = getColumnVisibility();
    
    // Check all checkboxes
    document.querySelectorAll('.column-item input[type="checkbox"]:not(:disabled)').forEach(checkbox => {
        checkbox.checked = true;
        visibility[checkbox.dataset.columnId] = true;
    });
    
    saveColumnVisibility(visibility);
    applyColumnVisibility(visibility);
    showNotification('All columns shown', 'success');
}

// Deselect all columns (except locked ones)
function deselectAllColumns() {
    const visibility = getColumnVisibility();
    
    // Uncheck all non-disabled checkboxes
    document.querySelectorAll('.column-item input[type="checkbox"]:not(:disabled)').forEach(checkbox => {
        checkbox.checked = false;
        visibility[checkbox.dataset.columnId] = false;
    });
    
    saveColumnVisibility(visibility);
    applyColumnVisibility(visibility);
    showNotification('All columns hidden (except required)', 'success');
}

// Reset to default (all visible)
function resetToDefault() {
    const visibility = {};
    
    // Set all to visible
    columnDefinitions.basic.forEach(col => {
        visibility[col.id] = true;
    });
    columnDefinitions.technical.forEach(col => {
        visibility[col.id] = true;
    });
    
    saveColumnVisibility(visibility);
    
    // Update checkboxes
    document.querySelectorAll('.column-item input[type="checkbox"]').forEach(checkbox => {
        if (!checkbox.disabled) {
            checkbox.checked = true;
        }
    });
    
    applyColumnVisibility(visibility);
    
    // Show success message
    showNotification('Column visibility reset to default', 'success');
}

// Show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `column-notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        background: ${type === 'success' ? '#28a745' : '#17a2b8'};
        color: white;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        animation: slideIn 0.3s ease;
        font-weight: 500;
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            if (notification.parentNode) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing column manager...');
    // Small delay to ensure tables are rendered
    setTimeout(() => {
        initializeColumnManager();
    }, 500);
});
