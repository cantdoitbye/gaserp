<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Png;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PngImport implements ToModel, WithHeadingRow, WithValidation
{
  /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Parse dates safely
        $agreementDate = $this->parseDate($row['agreement_date'] ?? null);
        $startDate = $this->parseDate($row['start_date'] ?? null);
        $plbDate = $this->parseDate($row['plb_date'] ?? null);
        $pdtDate = $this->parseDate($row['pdt_date'] ?? null);
        $gcDate = $this->parseDate($row['gc_date'] ?? null);
        $mmtDate = $this->parseDate($row['mmt_date'] ?? null);
        $conversionDate = $this->parseDate($row['conversion_date'] ?? null);
        $dateOfReport = $this->parseDate($row['date_of_report'] ?? null);

        return new Png([
            // Basic Information
            'po_number' => $row['po_number'] ?? null,
            'service_order_no' => $row['service_order_no'],
            'agreement_date' => $agreementDate,
            'booking_by' => $row['booking_by'] ?? null,
            'start_date' => $startDate,
            'plan_type' => $this->normalizePlanType($row['plan_type'] ?? null),
            'customer' => $row['customer'] ?? null,
            'application_no' => $row['application_no'] ?? null,
            'notification_numbers' => $row['notification_numbers'] ?? null,
            'customer_name' => $row['customer_name'],
            'house_no' => $row['house_no'] ?? null,
            'street_1' => $row['street_1'] ?? null,
            'street_2' => $row['street_2'] ?? null,
            'street_3' => $row['street_3'] ?? null,
            'street_4' => $row['street_4'] ?? null,
            'customer_contact_no' => $row['customer_contact_no'] ?? null,
            
            // Additional Customer Information
            'geyser_point' => $this->parseNumber($row['geyser_point'] ?? 0),
            'extra_kitchen' => $this->parseNumber($row['extra_kitchen'] ?? 0),
            'sla_days' => $this->parseNumber($row['sla_days'] ?? null),
            'current_remarks' => $row['current_remarks'] ?? null,
            'witnesses_name_date' => $row['witnesses_name_date'] ?? null,
            'previous_remarks' => $row['previous_remarks'] ?? null,
            'witnesses_name_date_2' => $row['witnesses_name_date_2'] ?? null,
            'reported' => $this->normalizeStatus($row['reported'] ?? null),
            'plb_name' => $this->normalizePersonName($row['plb_name'] ?? null),
            'plb_date' => $plbDate,
            'pdt_date' => $pdtDate,
            'pdt_tpi' => $row['pdt_tpi'] ?? null,
            'pe_status' => $this->normalizeStatus($row['pe_status'] ?? null),
            'gc_date' => $gcDate,
            'gc_tpi' => $this->normalizePersonName($row['gc_tpi'] ?? null),
            'mmt_date' => $mmtDate,
            'mmt_tpi' => $row['mmt_tpi'] ?? null,
            'conversion_date' => $conversionDate,
            
            // Conversion Details
            'conversion_technician' => $this->normalizePersonName($row['conversion_technician'] ?? null),
            'date_of_report' => $dateOfReport,
            'plumber' => $this->normalizePersonName($row['plumber'] ?? null),
            'conversion_payment' => $this->normalizePaymentPeriod($row['conversion_payment'] ?? null),
            'meter_number' => $row['meter_number'] ?? null,
            'meter_reading' => $this->parseDecimal($row['meter_reading'] ?? null),
            
            // GI Pipe Measurements
            'gi_guard_to_main_valve_half_inch' => $this->parseDecimal($row['gi_guard_to_main_valve_half_inch'] ?? null),
            'gi_main_valve_to_meter_half_inch' => $this->parseDecimal($row['gi_main_valve_to_meter_half_inch'] ?? null),
            'gi_meter_to_geyser_half_inch' => $this->parseDecimal($row['gi_meter_to_geyser_half_inch'] ?? null),
            'gi_geyser_point_half_inch' => $this->parseDecimal($row['gi_geyser_point_half_inch'] ?? null),
            'extra_kitchen_point' => $this->parseDecimal($row['extra_kitchen_point'] ?? null),
            'total_gi' => $this->parseDecimal($row['total_gi'] ?? null),
            
            // Regulators and Components
            'high_press_1_6_reg' => $this->parseNumber($row['high_press_1_6_reg'] ?? 0),
            'low_press_2_5_reg' => $this->parseNumber($row['low_press_2_5_reg'] ?? 0),
            'reg_qty' => $this->parseNumber($row['reg_qty'] ?? 0),
            'gas_tap' => $this->parseNumber($row['gas_tap'] ?? 0),
            'valve_half_inch' => $this->parseNumber($row['valve_half_inch'] ?? 0),
            'gi_coupling_half_inch' => $this->parseNumber($row['gi_coupling_half_inch'] ?? 0),
            
            // Fittings
            'gi_elbow_half_inch' => $this->parseNumber($row['gi_elbow_half_inch'] ?? 0),
            'calmp_half_inch' => $this->parseNumber($row['calmp_half_inch'] ?? 0),
            'gi_tee_half_inch' => $this->parseNumber($row['gi_tee_half_inch'] ?? 0),
            'anaconda' => $this->parseNumber($row['anaconda'] ?? 0),
            'open_cut_20mm' => $this->parseDecimal($row['open_cut_20mm'] ?? 0),
            'boring_20mm' => $this->parseDecimal($row['boring_20mm'] ?? 0),
            'total_mdpe_pipe_20mm' => $this->parseDecimal($row['total_mdpe_pipe_20mm'] ?? 0),
            'tee_20mm' => $this->parseNumber($row['tee_20mm'] ?? 0),
            'rcc_guard_20mm' => $this->parseNumber($row['rcc_guard_20mm'] ?? 0),
            'gf_coupler_20mm' => $this->parseNumber($row['gf_coupler_20mm'] ?? 0),
            
            // GF Saddles
            'gf_saddle_32x20mm' => $this->parseNumber($row['gf_saddle_32x20mm'] ?? 0),
            'gf_saddle_63x20mm' => $this->parseNumber($row['gf_saddle_63x20mm'] ?? 0),
            'gf_saddle_63x32mm' => $this->parseNumber($row['gf_saddle_63x32mm'] ?? 0),
            'gf_saddle_125x32' => $this->parseNumber($row['gf_saddle_125x32'] ?? 0),
            'gf_saddle_90x20mm' => $this->parseNumber($row['gf_saddle_90x20mm'] ?? 0),
            'gf_reducer_32x20mm' => $this->parseNumber($row['gf_reducer_32x20mm'] ?? 0),
            
            // Additional Fields
            'nepl_claim' => $row['nepl_claim'] ?? null,
            'offline_drawing' => $row['offline_drawing'] ?? null,
            'gc_done_by' => $row['gc_done_by'] ?? null,
            'v_lookup' => $row['v_lookup'] ?? null,
        ]);
    }

    /**
     * Parse date from various formats
     */
    private function parseDate($dateValue)
    {
        if (empty($dateValue)) {
            return null;
        }

        try {
            // If it's already a Carbon instance
            if ($dateValue instanceof Carbon) {
                return $dateValue->format('Y-m-d');
            }

            // If it's a numeric value (Excel date serial number)
            if (is_numeric($dateValue)) {
                return Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateValue)->format('Y-m-d'));
            }

            // Try to parse as string
            return Carbon::parse($dateValue)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Parse number safely
     */
    private function parseNumber($value)
    {
        if (empty($value) || !is_numeric($value)) {
            return 0;
        }
        return (int) $value;
    }

    /**
     * Parse decimal safely
     */
    private function parseDecimal($value)
    {
        if (empty($value) || !is_numeric($value)) {
            return null;
        }
        return (float) $value;
    }

    /**
     * Normalize plan type
     */
    private function normalizePlanType($planType)
    {
        if (empty($planType)) {
            return null;
        }
        
        $planType = strtolower(trim($planType));
        $mapping = [
            'apartment' => 'apartment',
            'individual' => 'individual',
            'commercial' => 'commercial',
        ];
        
        return $mapping[$planType] ?? null;
    }

    /**
     * Normalize status values
     */
    private function normalizeStatus($status)
    {
        if (empty($status)) {
            return null;
        }
        
        return strtolower(trim($status));
    }

    /**
     * Normalize person names
     */
    private function normalizePersonName($name)
    {
        if (empty($name)) {
            return null;
        }
        
        return strtolower(trim($name));
    }

    /**
     * Normalize payment period
     */
    private function normalizePaymentPeriod($period)
    {
        if (empty($period)) {
            return null;
        }
        
        $period = strtolower(trim($period));
        $mapping = [
            'jan\'24' => 'jan_24',
            'feb\'24' => 'feb_24',
            'mar\'24' => 'mar_24',
            'apr\'24' => 'apr_24',
            'may\'24' => 'may_24',
            'jun\'24' => 'jun_24',
            'jul\'24' => 'jul_24',
            'aug\'24' => 'aug_24',
            'sep\'24' => 'sep_24',
            'oct\'24' => 'oct_24',
            'nov\'24' => 'nov_24',
            'dec\'24' => 'dec_24',
        ];
        
        return $mapping[$period] ?? $period;
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'service_order_no' => 'required|string|unique:pngs,service_order_no',
            'customer_name' => 'required|string',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'service_order_no.required' => 'Service Order Number is required',
            'service_order_no.unique' => 'Service Order Number already exists',
            'customer_name.required' => 'Customer Name is required',
            'plan_type.in' => 'Plan Type must be one of: apartment, individual, commercial',
        ];
    }
}
