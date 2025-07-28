<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLegalDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'legal_document_type_id',
         'license_number',
        'is_required',
        'issue_date',
          'application_date',
        'validity_date',
         'reapply_date',
        'document_file',
        'status',
         'reapplication_status',
    ];

   

      protected $casts = [
        'is_required' => 'boolean',
        'issue_date' => 'date',
        'validity_date' => 'date',
        'application_date' => 'date',
        'reapply_date' => 'date',

    ];

    /**
     * Get the legal document type that owns the project legal document.
     */
    public function legalDocumentType()
    {
        return $this->belongsTo(LegalDocumentType::class);
    }

    /**
     * Get the project that owns the project legal document.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the notifications for the project legal document.
     */
    public function notifications()
    {
        return $this->hasMany(LegalNotification::class);
    }

    /**
     * Check if the document is expired.
     */
    public function isExpired()
    {
        if (!$this->validity_date) {
            return false;
        }
        
        return Carbon::now()->gt($this->validity_date);
    }

    /**
     * Calculate days until expiry.
     */
    // public function daysUntilExpiry()
    // {
    //     if (!$this->validity_date) {
    //         return null;
    //     }
        
    //     return Carbon::now()->diffInDays($this->validity_date, false);
    // }

    public function daysUntilExpiry()
    {
        if (!$this->validity_date) {
            return null;
        }
        
        $today = Carbon::now()->startOfDay();
        $validityDate = Carbon::parse($this->validity_date)->startOfDay();
        
        // Calculate the difference in days
        // Negative value means document is expired (days overdue)
        // Positive value means document is valid (days remaining)
        return $today->diffInDays($validityDate, false);
    }

    /**
     * Update the document status based on validity date
     * Sets status to 'expired', 'upcoming_expiry', or 'valid'
     * 
     * @return void
     */
    // public function updateStatus()
    // {
    //     if (!$this->validity_date) {
    //         $this->status = 'no_expiry';
    //         $this->save();
    //         return;
    //     }
        
    //     $daysLeft = $this->daysUntilExpiry();
        
    //     if ($daysLeft < 0) {
    //         // Document has expired (negative days means we're past validity date)
    //         $this->status = 'expired';
    //     } elseif ($daysLeft <= 30) {
    //         // Document will expire within 30 days
    //         $this->status = 'upcoming_expiry';
    //     } else {
    //         // Document is valid with more than 30 days remaining
    //         $this->status = 'valid';
    //     }
        
    //     $this->save();
    // }

    /**
     * Get a formatted string showing days until expiry or days overdue
     * 
     * @return string
     */
    public function getFormattedDaysStatus()
    {
        if (!$this->validity_date) {
            return '-';
        }
        
        $days = $this->daysUntilExpiry();
        
        if ($this->status === 'reapplied') {
        return 'Reapplied';
    } else if ($days < 0) {
        // Document is expired (negative days)
        return abs($days) . ' days overdue';
    } else {
        // Document is valid or approaching expiry (positive days)
        return $days . ' days left';
    }
    }

    /**
     * Get HTML for days status with appropriate styling
     * 
     * @return string
     */
    public function getDaysStatusHtml()
    {
        if (!$this->validity_date) {
            return '-';
        }
        
        $days = $this->daysUntilExpiry();
        $formattedText = $this->getFormattedDaysStatus();
        
        if ($days < 0) {
            // Expired documents
            return '<div class="days-count expired">' . $formattedText . '</div>';
        } elseif ($days <= 30) {
            // Upcoming expiry
            return '<div class="days-count warning">' . $formattedText . '</div>';
        } else {
            // Valid documents
            return '<div class="days-count valid">' . $formattedText . '</div>';
        }
    }

    /**
     * Update document status based on dates.
     */
    public function updateStatus()
    {
        // if (!$this->validity_date) {
        //     $this->status = 'pending';
        //     return $this->save();
        // }
         if (!$this->validity_date) {
        $this->status = 'no_expiry';
        $this->save();
        return;
    }

        $daysUntilExpiry = $this->daysUntilExpiry();

        if ($daysUntilExpiry < 0 && $this->reapplication_status === 'completed') {
        $this->status = 'reapplied';
    } else if ($daysUntilExpiry < 0) {
        // Document has expired (negative days means we're past validity date)
        $this->status = 'expired';
    } else if ($daysUntilExpiry <= 30) {
        // Document will expire within 30 days
        $this->status = 'upcoming_expiry';
    } else {
        // Document is valid with more than 30 days remaining
        $this->status = 'valid';
    }

        return $this->save();
    }
}
