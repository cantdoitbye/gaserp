<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Png extends Model
{

 use HasFactory;

    protected $fillable = [
        // Basic Information (matching Excel layout)
        'name',
        'agreement_date',
        'customer_no',
        'customer_name',
        'service_order_no',
        'application_no',
        'name',
        'contact_no',
        'address',
        'area',
        'scheme',
        'geyser',
        'kitchen',
        'sla_days',
        
        // Service information
        'service_order_no',
        'po_number',
        'start_date',
        'booking_by',
        'plan_type',
        'customer_name',
        'customer',
        'customer_contact_no',
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
        'plb_name',
        'plb_date',
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

        'png_type'
    ];

    // protected $guarded = [];

    protected $casts = [
        'agreement_date' => 'date',
        'start_date' => 'date',
        'plb_date' => 'date',
        'pdt_date' => 'date',
        'ground_connections_date' => 'date',
        'mmt_date' => 'date',
        'conversion_date' => 'date',
        'report_submission_date' => 'date',
        // 'plb_date' => 'date',
        'gc_date' => 'date',
        'measurements_data' => 'array',
        'additional_documents' => 'array',
        'job_cards_paths' => 'array',
        'autocad_dwg_paths' => 'array',
        'site_visit_reports_paths' => 'array',
        'other_documents_paths' => 'array',
        'geyser' => 'integer',
        'kitchen' => 'integer',
        'sla_days' => 'integer',
        'meter_reading' => 'decimal:2'
    ];

    /**
     * Get the measurement type for this PNG job
     */
    public function measurementType()
    {
        return $this->belongsTo(PngMeasurementType::class, 'png_measurement_type_id');
    }

    /**
     * Get Connections Status options (from Excel)
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
     * Get Area options (from Excel dropdown)
     */
    public static function getAreaOptions()
    {
        return [
            'bungalow' => 'Bungalow',
            'tapping' => 'Tapping',
            'row_house' => 'Row House',
            'floor_tf' => 'Floor TF'
        ];
    }

    /**
     * Get Scheme options
     */
    public static function getSchemeOptions()
    {
        return [
            'bungalow' => 'Bungalow',
            'tapping' => 'Tapping', 
            'row_house' => 'Row-house',
            'floor_trf' => 'Floor Trf'
        ];
    }

    /**
     * Get Plan Type options 
     */
    public static function getPlanTypeOptions()
    {
        return [
            'apartment' => 'Apartment',
            'bungalow' => 'Bungalow',
            'rowhouse' => 'RowHouse',
            'commercial' => 'Commercial',
            'farmhouse' => 'FarmHouse'
        ];
    }

    /**
     * Get PE Status options
     */
    public static function getPeStatusOptions()
    {
        return [
            'online' => 'Online',
            'tapping' => 'Tapping',
            'pending' => 'Pending',
            'reported' => 'Reported'
        ];
    }

    /**
     * Get Reported options
     */
    public static function getReportedOptions()
    {
        return [
            'reported' => 'Reported',
            'not_reported' => 'Not Reported'
        ];
    }

    /**
     * Get PLB Name options
     */
    public static function getPlbNameOptions()
    {
        return [
            'plb1' => 'PLB Team 1',
            'plb2' => 'PLB Team 2',
            'plb3' => 'PLB Team 3'
        ];
    }

    /**
     * Get GC TPI options
     */
    public static function getGcTpiOptions()
    {
        return [
            'tpi1' => 'TPI Inspector 1',
            'tpi2' => 'TPI Inspector 2',
            'tpi3' => 'TPI Inspector 3'
        ];
    }

    /**
     * Get Plumber options
     */
    public static function getPlumberOptions()
    {
        return [
            'plumber1' => 'Plumber Team A',
            'plumber2' => 'Plumber Team B',
            'plumber3' => 'Plumber Team C'
        ];
    }

    /**
     * Get Conversion Technician options
     */
    public static function getConversionTechnicianOptions()
    {
        return [
            'tech1' => 'Technician 1',
            'tech2' => 'Technician 2',
            'tech3' => 'Technician 3'
        ];
    }

    /**
     * Get Conversion Payment options
     */
    public static function getConversionPaymentOptions()
    {
        return [
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'yearly' => 'Yearly'
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
                continue; // Skip calculated fields in calculation
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
