<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Png extends Model
{
    use HasFactory;

    protected $fillable = [
        // Basic Information (matching Excel layout)
        'po_number',
        'service_order_no',
        'agreement_date',
        'booking_by',
        'start_date',
        'plan_type',
        'customer',
        'customer_no',
        'customer_name',
        'application_no',
        'notification_numbers',
        'house_no',
        'street_1',
        'street_2', 
        'street_3',
        'street_4',
        'customer_contact_no',
        'geyser_point',
        'extra_kitchen',
        'sla_days',
        'current_remarks',
        
        // Service and Location Information
        'name',
        'contact_no',
        'address',
        'area',
        'scheme',
        'geyser',
        'kitchen',
        
        // Technical and Status Information
        'connections_status',
        'witnesses_name_date',
        'previous_remarks',
        'reported',
        'plb_name',
        'plb_date',
        'pdt_date',
        'pdt_tpi',
        'gc_date',
        'gc_tpi',
        'mmt_date',
        'mmt_tpi',
        'conversion_date',
        'conversion_technician',
        'conversion_payment',
        'meter_number',
        'meter_reading',
        'plumber',
        'witnesses_name_date_2',
        'date_of_report',
        
        // Claims and Administrative
        'nepl_claim',
        'offline_drawing',
        'gc_done_by',
        'v_lookup',
        'created_at_field',
        'updated_at_field',
        
        // Dynamic measurements - keeping for future use (commented out in migration)
        'png_measurement_type_id',
        'measurements_data',
        'dynamic_measurements_backup',
        
        // File paths
        'scan_copy_path',
        'autocad_drawing_path',
        'certificate_path',
        'job_cards_paths',
        'autocad_dwg_paths',
        'site_visit_reports_paths',
        'other_documents_paths',
        'additional_documents',
        
        // Excel Specific Measurement Fields
        // GI (Galvanized Iron) Measurements 
        'gi_guard_to_main_valve_half_inch',
        'gi_main_valve_to_meter_half_inch',
        'gi_meter_to_geyser_half_inch',
        'gi_geyser_point_half_inch',
        'extra_kitchen_point',
        'total_gi',
        
        // Regulators and Components
        'high_press_1_6_reg',
        'low_press_2_5_reg',
        'reg_qty',
        'gas_tap',
        'valve_half_inch',
        'gi_coupling_half_inch',
        'gi_elbow_half_inch',
        'clamp_half_inch',
        'gi_tee_half_inch',
        'anaconda',
        
        // Pipe and Excavation
        'open_cut_20mm',
        'boring_20mm',
        'total_mdpe_pipe_20mm',
        'tee_20mm',
        'rcc_guard_20mm',
        
        // GF (Gas Fittings) Components
        'gf_coupler_20mm',
        'gf_saddle_32x20mm',
        'gf_saddle_63x20mm',
        'gf_saddle_63x32mm',
        'gf_saddle_125x32',
        'gf_saddle_90x20mm',
        'gf_reducer_32x20mm',
        
        // Other fields
        'png_type',
        'ra_bill_no',
        'remarks'
    ];

    protected $casts = [
        // Date fields
        'agreement_date' => 'date',
        'start_date' => 'date',
        'plb_date' => 'date',
        'pdt_date' => 'date',
        'gc_date' => 'date',
        'mmt_date' => 'date',
        'conversion_date' => 'date',
        'date_of_report' => 'date',
        'created_at_field' => 'datetime',
        'updated_at_field' => 'datetime',
        
        // Decimal fields
        'gi_guard_to_main_valve_half_inch' => 'decimal:2',
        'gi_main_valve_to_meter_half_inch' => 'decimal:2',
        'gi_meter_to_geyser_half_inch' => 'decimal:2',
        'gi_geyser_point_half_inch' => 'decimal:2',
        'extra_kitchen_point' => 'decimal:2',
        'total_gi' => 'decimal:2',
        'open_cut_20mm' => 'decimal:2',
        'boring_20mm' => 'decimal:2',
        'total_mdpe_pipe_20mm' => 'decimal:2',
        'conversion_payment' => 'decimal:2',
        'meter_reading' => 'decimal:2',
        
        // Integer fields
        'high_press_1_6_reg' => 'integer',
        'low_press_2_5_reg' => 'integer',
        'reg_qty' => 'integer',
        'gas_tap' => 'integer',
        'valve_half_inch' => 'integer',
        'gi_coupling_half_inch' => 'integer',
        'gi_elbow_half_inch' => 'integer',
        'clamp_half_inch' => 'integer',
        'gi_tee_half_inch' => 'integer',
        'anaconda' => 'integer',
        'tee_20mm' => 'integer',
        'rcc_guard_20mm' => 'integer',
        'gf_coupler_20mm' => 'integer',
        'gf_saddle_32x20mm' => 'integer',
        'gf_saddle_63x20mm' => 'integer',
        'gf_saddle_63x32mm' => 'integer',
        'gf_saddle_125x32' => 'integer',
        'gf_saddle_90x20mm' => 'integer',
        'gf_reducer_32x20mm' => 'integer',
        'geyser' => 'integer',
        'kitchen' => 'integer',
        'sla_days' => 'integer',
        
        // JSON fields (for file storage and backup data)
        'measurements_data' => 'array',
        'additional_documents' => 'array',
        'job_cards_paths' => 'array',
        'autocad_dwg_paths' => 'array',
        'site_visit_reports_paths' => 'array',
        'other_documents_paths' => 'array',
        'dynamic_measurements_backup' => 'array'
    ];

    /**
     * Get the measurement type for this PNG job (keeping for backward compatibility)
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
     * Get Plan Type options (from Excel)
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

     public static function getConversionStatusOptions()
    {
        return [
            'conv_done' => 'CONV Done',
            'comm' => 'COMM',
            'pending' => 'Pending'
        ];
    }

      public static function getAreaOptions()
    {
        return [
            'bungalow' => 'Bungalow',
            'tapping' => 'Tapping',
            'row_house' => 'Row House',
            'floor_tf' => 'Floor TF'
        ];
    }

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
     * Get Booking By options (from Excel)
     */
    public static function getBookingByOptions()
    {
        return [
            'pinal' => 'PINAL',
            'ggl' => 'GGL',
            'online' => 'Online',
            'offline' => 'Offline'
        ];
    }

    /**
     * Get Reported Status options
     */
    public static function getReportedOptions()
    {
        return [
            'reported' => 'REPORTED'
        ];
    }

    /**
     * Get Offline Drawing status options
     */
    public static function getOfflineDrawingOptions()
    {
        return [
            'done' => 'DONE'
        ];
    }

    /**
     * Calculate total GI measurement
     */
    public function calculateTotalGi()
    {
        return ($this->gi_guard_to_main_valve_half_inch ?? 0) +
               ($this->gi_main_valve_to_meter_half_inch ?? 0) +
               ($this->gi_meter_to_geyser_half_inch ?? 0) +
               ($this->gi_geyser_point_half_inch ?? 0) +
               ($this->extra_kitchen_point ?? 0);
    }

    /**
     * Calculate total MDPE pipe
     */
    public function calculateTotalMdpe()
    {
        return ($this->open_cut_20mm ?? 0) + ($this->boring_20mm ?? 0);
    }

    /**
     * Get all measurement fields as an array for export/import
     */
    public function getMeasurementFieldsArray()
    {
        return [
            // GI Measurements
            'gi_guard_to_main_valve_half_inch' => $this->gi_guard_to_main_valve_half_inch,
            'gi_main_valve_to_meter_half_inch' => $this->gi_main_valve_to_meter_half_inch,
            'gi_meter_to_geyser_half_inch' => $this->gi_meter_to_geyser_half_inch,
            'gi_geyser_point_half_inch' => $this->gi_geyser_point_half_inch,
            'extra_kitchen_point' => $this->extra_kitchen_point,
            'total_gi' => $this->total_gi,
            
            // Regulators and Components
            'high_press_1_6_reg' => $this->high_press_1_6_reg,
            'low_press_2_5_reg' => $this->low_press_2_5_reg,
            'reg_qty' => $this->reg_qty,
            'gas_tap' => $this->gas_tap,
            'valve_half_inch' => $this->valve_half_inch,
            'gi_coupling_half_inch' => $this->gi_coupling_half_inch,
            'gi_elbow_half_inch' => $this->gi_elbow_half_inch,
            'clamp_half_inch' => $this->clamp_half_inch,
            'gi_tee_half_inch' => $this->gi_tee_half_inch,
            'anaconda' => $this->anaconda,
            
            // Pipe and Excavation
            'open_cut_20mm' => $this->open_cut_20mm,
            'boring_20mm' => $this->boring_20mm,
            'total_mdpe_pipe_20mm' => $this->total_mdpe_pipe_20mm,
            'tee_20mm' => $this->tee_20mm,
            'rcc_guard_20mm' => $this->rcc_guard_20mm,
            
            // GF Components
            'gf_coupler_20mm' => $this->gf_coupler_20mm,
            'gf_saddle_32x20mm' => $this->gf_saddle_32x20mm,
            'gf_saddle_63x20mm' => $this->gf_saddle_63x20mm,
            'gf_saddle_63x32mm' => $this->gf_saddle_63x32mm,
            'gf_saddle_125x32' => $this->gf_saddle_125x32,
            'gf_saddle_90x20mm' => $this->gf_saddle_90x20mm,
            'gf_reducer_32x20mm' => $this->gf_reducer_32x20mm,
        ];
    }

    /**
     * Scope for filtering by connections status
     */
    public function scopeByConnectionsStatus($query, $status)
    {
        return $query->where('connections_status', $status);
    }

    /**
     * Scope for filtering by plan type
     */
    public function scopeByPlanType($query, $planType)
    {
        return $query->where('plan_type', $planType);
    }

    /**
     * Scope for filtering by booking method
     */
    public function scopeByBookingBy($query, $bookingBy)
    {
        return $query->where('booking_by', $bookingBy);
    }
}