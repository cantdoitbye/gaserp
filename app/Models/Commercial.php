<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commercial extends Model
{
    use HasFactory;

    protected $fillable = [
        // Basic Information (matching Excel layout)
        'agreement_date',
        'customer_no',
        'customer_name',
        'service_order_no',
        'application_no',
        'contact_no',
        'address',
        'area',
        'scheme',
        'sla_days',
        
        // Service information
        'po_number',
        'start_date',
        'booking_by',
        'plan_type',
        'notification_numbers',
        'house_no',
        'street_1',
        'street_2', 
        'street_3',
        'street_4',
        
        // Technical Information
        'connections_status',
        'plb_name',
        'plb_date',
        'pdt_date',
        'pdt_witness_by',
        'ground_connections_date',
        'ground_connections_witness_by',
        'isolation_name',
        'mmt_date',
        'mmt_witness_by',
        'conversion_technician_name',
        'conversion_date',
        'conversion_status',
        'report_submission_date',
        'meter_number',
        'ra_bill_no',
        'remarks',
        
        // Team information
        'pe_status',
        'reported',
        'pdt_tpi',
        'gc_date',
        'gc_tpi',
        'mmt_tpi',
        'conversion_payment',
        'meter_reading',
        'plumber',
        'witnesses_name_date',
        'witnesses_name_date_2',
        'current_remarks',
        'previous_remarks',
        'nepl_claim',
        'offline_drawing',
        'gc_done_by',
        'v_lookup',
        
        // Dynamic measurements
        'png_measurement_type_id',
        'measurements_data',
        
        // File paths
        'scan_copy_path',
        'autocad_drawing_path',
        'certificate_path',
        'job_cards_paths',
        'autocad_dwg_paths',
        'site_visit_reports_paths',
        'other_documents_paths',
        'additional_documents',

        'commercial_type'
    ];

    protected $casts = [
        'agreement_date' => 'date',
        'start_date' => 'date',
        'plb_date' => 'date',
        'pdt_date' => 'date',
        'ground_connections_date' => 'date',
        'mmt_date' => 'date',
        'conversion_date' => 'date',
        'report_submission_date' => 'date',
        'gc_date' => 'date',
        'measurements_data' => 'array',
        'additional_documents' => 'array',
        'job_cards_paths' => 'array',
        'autocad_dwg_paths' => 'array',
        'site_visit_reports_paths' => 'array',
        'other_documents_paths' => 'array',
        'sla_days' => 'integer',
        'meter_reading' => 'decimal:2'
    ];

    /**
     * Get the measurement type for this Commercial job
     */
    public function measurementType()
    {
        return $this->belongsTo(PngMeasurementType::class, 'png_measurement_type_id');
    }

    /**
     * Get Connections Status options
     */
    public static function getConnectionsStatusOptions()
    {
        return [
            'workable' => 'Workable',
            'not_workable' => 'Not Workable',
            'plb_done' => 'PLB Done',
            'pdt_pending' => 'PDT Pending',
            'gc_pending' => 'GC Pending',
            'mmt_pending' => 'MMT Pending',
            'conv_pending' => 'CONV Pending',
            'comm' => 'COMM',
            'bill_pending' => 'Bill Pending',
            'bill_received' => 'Bill Received'
        ];
    }

    /**
     * Get Conversion Status options
     */
    public static function getConversionStatusOptions()
    {
        return [
            'conv_done' => 'CONV Done',
            'comm' => 'COMM',
            'pending' => 'Pending'
        ];
    }

    /**
     * Get Area options
     */
    public static function getAreaOptions()
    {
        return [
            'industrial' => 'Industrial',
            'commercial_complex' => 'Commercial Complex',
            'office_building' => 'Office Building',
            'retail_shop' => 'Retail Shop',
            'restaurant' => 'Restaurant',
            'hotel' => 'Hotel'
        ];
    }

    /**
     * Get Scheme options
     */
    public static function getSchemeOptions()
    {
        return [
            'commercial_standard' => 'Commercial Standard',
            'industrial_heavy' => 'Industrial Heavy', 
            'retail_basic' => 'Retail Basic',
            'hospitality' => 'Hospitality'
        ];
    }

    /**
     * Get calculated SLA days from agreement date
     */
    public function getSlaCalculatedDaysAttribute()
    {
        if (!$this->agreement_date) {
            return null;
        }
        
        return now()->diffInDays($this->agreement_date, false);
    }

    /**
     * Get SLA days status with color coding
     */
    public function getSlaStatusAttribute()
    {
        $calculatedDays = $this->sla_calculated_days;
        $targetSla = $this->sla_days;
        
        if ($calculatedDays === null || $targetSla === null) {
            return ['status' => 'unknown', 'class' => 'text-muted'];
        }
        
        if ($calculatedDays <= $targetSla) {
            return ['status' => 'on_time', 'class' => 'text-success'];
        } else {
            $overdueDays = $calculatedDays - $targetSla;
            return [
                'status' => 'overdue', 
                'class' => 'text-danger',
                'overdue_days' => $overdueDays
            ];
        }
    }

    public function getCalculatedTotal()
    {
        if (!$this->measurements_data || !$this->measurementType) {
            return 0;
        }

        $total = 0;
        $fields = $this->measurementType->measurement_fields;
        
        foreach ($fields as $field) {
            if (isset($field['calculated']) && $field['calculated']) {
                continue;
            }
            
            if ($field['type'] === 'decimal') {
                $value = $this->measurements_data[$field['name']] ?? 0;
                $total += (float) $value;
            }
        }
        
        return $total;
    }

    /**
     * Get measurement value by field name
     */
    public function getMeasurement($fieldName, $default = null)
    {
        return $this->measurements_data[$fieldName] ?? $default;
    }

    /**
     * Set measurement value
     */
    public function setMeasurement($fieldName, $value)
    {
        $measurements = $this->measurements_data ?? [];
        $measurements[$fieldName] = $value;
        $this->measurements_data = $measurements;
    }

    /**
     * Get full address
     */
    public function getFullAddressAttribute()
    {
        $addressParts = array_filter([
            $this->house_no,
            $this->street_1,
            $this->street_2,
            $this->street_3,
            $this->street_4,
            $this->address
        ]);
        
        return implode(', ', $addressParts);
    }

    /**
     * Scope for filtering by connections status
     */
    public function scopeConnectionsStatus($query, $status)
    {
        return $query->where('connections_status', $status);
    }

    /**
     * Scope for filtering by area
     */
    public function scopeArea($query, $area)
    {
        return $query->where('area', $area);
    }

    /**
     * Scope for filtering by conversion status
     */
    public function scopeConversionStatus($query, $status)
    {
        return $query->where('conversion_status', $status);
    }

    /**
     * Scope for date range filtering
     */
    public function scopeDateRange($query, $startDate, $endDate, $dateField = 'agreement_date')
    {
        return $query->whereBetween($dateField, [$startDate, $endDate]);
    }
}
