<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PePng extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_order_number',
        'category',
        'plumbing_date',
        'plumber_id',
        'gc_date',
        'mmt_date',
        'site_visits',
        'remarks',
        'bill_ra_no',
        'plb_bill_status',
        'scan_copy_path',
        'sla_days',
        'pe_dpr',
        'autocad_drawing_path',
        'consumption_details',
        'free_issue_details',
    ];

    protected $casts = [
        'plumbing_date' => 'date',
        'gc_date' => 'date',
        'mmt_date' => 'date',
        // 'site_visits' => 'array',
        // 'consumption_details' => 'array',
        // 'free_issue_details' => 'array',
    ];

    /**
     * Get the plumber for this PE/PNG job
     */
    public function plumber()
    {
        return $this->belongsTo(Plumber::class);
    }



   public function getSiteVisitsArrayAttribute()
    {
        if (empty($this->site_visits)) {
            return [];
        }

        // If it's already an array, return it
        if (is_array($this->site_visits)) {
            return $this->site_visits;
        }

        // Try to decode the JSON string
        try {
            $decoded = json_decode($this->site_visits, true);
            return is_array($decoded) ? $decoded : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get consumption details as array - safely parses JSON
     */
    public function getConsumptionDetailsArrayAttribute()
    {
        if (empty($this->consumption_details)) {
            return [];
        }

        // If it's already an array, return it
        if (is_array($this->consumption_details)) {
            return $this->consumption_details;
        }

        // Try to decode the JSON string
        try {
            $decoded = json_decode($this->consumption_details, true);
            return is_array($decoded) ? $decoded : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get free issue details as array - safely parses JSON
     */
    public function getFreeIssueDetailsArrayAttribute()
    {
        if (empty($this->free_issue_details)) {
            return [];
        }

        // If it's already an array, return it
        if (is_array($this->free_issue_details)) {
            return $this->free_issue_details;
        }

        // Try to decode the JSON string
        try {
            $decoded = json_decode($this->free_issue_details, true);
            return is_array($decoded) ? $decoded : [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
