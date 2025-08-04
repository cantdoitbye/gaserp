<?php

namespace App\Imports;

use App\Models\Png;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class PngImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsOnError, SkipsOnFailure, WithStartRow
{
    private $errors = [];
    private $successCount = 0;
    private $skipCount = 0;
    private $updateCount = 0;
    private $skipDuplicates;
    private $updateDuplicates;

    public function __construct($skipDuplicates = true, $updateDuplicates = false)
    {
        $this->skipDuplicates = $skipDuplicates;
        $this->updateDuplicates = $updateDuplicates;
    }

    /**
     * Start from row 2 (after headers)
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Transform a row of data to a model.
     */
    public function model(array $row)
    {
        try {
            // Clean and normalize the row data
            $row = $this->cleanRowData($row);
            
            // Skip completely empty rows
            if ($this->isEmptyRow($row)) {
                $this->skipCount++;
                return null;
            }

            // Map column headers to expected field names
            $mappedData = $this->mapColumnHeaders($row);

            // Convert and validate data types
            $processedData = $this->processDataTypes($mappedData);

            // Check for duplicates before creating model
            if (!empty($processedData['service_order_no'])) {
                $existing = Png::where('service_order_no', $processedData['service_order_no'])->first();
                if ($existing) {
                    if ($this->updateDuplicates) {
                        // Update existing record
                        $existing->update($processedData);
                        $this->updateCount++;
                        return null; // Don't create new record
                    } elseif ($this->skipDuplicates) {
                        // Skip duplicate
                        $this->errors[] = "Duplicate Service Order No '{$processedData['service_order_no']}' found. Record skipped.";
                        $this->skipCount++;
                        return null;
                    }
                    // If neither skip nor update, let it fail with database constraint error
                }
            }

            // Create the model
            $png = new Png($processedData);
            $this->successCount++;
            
            return $png;

        } catch (\Exception $e) {
            // Handle specific duplicate entry errors
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                if (preg_match("/Duplicate entry '(.+?)' for key/", $e->getMessage(), $matches)) {
                    $duplicateValue = $matches[1];
                    $this->errors[] = "Duplicate record found with value '{$duplicateValue}'. Record skipped.";
                } else {
                    $this->errors[] = "Duplicate record found. Record skipped.";
                }
            } else {
                $this->errors[] = "Row error: " . $e->getMessage();
            }
            
            Log::error('PNG Import Row Error: ' . $e->getMessage(), [
                'row_data' => $row,
                'error' => $e->getTraceAsString()
            ]);
            
            // Skip this row but don't fail the entire import
            $this->skipCount++;
            return null;
        }
    }

    /**
     * Clean row data - remove extra spaces, handle nulls, empty strings, and special characters
     */
    private function cleanRowData(array $row): array
    {
        $cleaned = [];
        foreach ($row as $key => $value) {
            // Clean the key
            $cleanKey = trim(strtolower(str_replace([' ', '-', '_'], '_', $key)));
            
            // Clean the value - handle various empty representations
            if (is_string($value)) {
                $value = trim($value);
                // Convert various empty representations to null
                if ($value === '' || $value === '?' || $value === '-' || $value === 'NULL' || $value === 'null' || $value === 'N/A' || $value === 'n/a') {
                    $value = null;
                }
            } elseif (is_null($value) || $value === '') {
                $value = null;
            }
            
            $cleaned[$cleanKey] = $value;
        }
        return $cleaned;
    }

    /**
     * Check if row is completely empty (only check essential fields)
     */
    private function isEmptyRow(array $row): bool
    {
        // Only consider row empty if ALL essential fields are empty
        $essentialFields = ['service_order_no', 'customer_name', 'po_number'];
        $hasAnyData = false;
        
        foreach ($essentialFields as $field) {
            $fieldValue = $row[$field] ?? $row[str_replace('_', '', $field)] ?? null;
            if (!empty($fieldValue)) {
                $hasAnyData = true;
                break;
            }
        }
        
        // If no essential fields have data, check if there's ANY data in the row
        if (!$hasAnyData) {
            foreach ($row as $value) {
                if (!empty($value)) {
                    $hasAnyData = true;
                    break;
                }
            }
        }
        
        return !$hasAnyData;
    }

    /**
     * Map various column header formats to expected field names
     */
    private function mapColumnHeaders(array $row): array
    {
        $mappings = [
            // Basic Information Mappings
            'po_number' => ['po_number', 'ponumber', 'po_no', 'po_num', 'purchase_order'],
            'service_order_no' => ['service_order_no', 'service_order_number', 'serviceorderno', 'order_no', 'orderno', 'service_order_num'],
            'agreement_date' => ['agreement_date', 'agreementdate', 'agreement_dt'],
            'booking_by' => ['booking_by', 'bookingby', 'booked_by'],
            'start_date' => ['start_date', 'startdate', 'start_dt'],
            'plan_type' => ['plan_type', 'plantype', 'plan'],
            'customer' => ['customer', 'customer_name', 'customername', 'name'],
            'customer_name' => ['customer_name', 'customername', 'name', 'customer'],
            'customer_no' => ['customer_no', 'customer_number', 'customerno', 'customernum', 'customer_num'],
            'application_no' => ['application_no', 'application_number', 'applicationno', 'application_num'],
            'notification_numbers' => ['notification_numbers', 'notificationnumbers', 'notification_no'],
            'house_no' => ['house_no', 'house_number', 'houseno', 'house_num'],
            'customer_contact_no' => ['customer_contact_no', 'contact_no', 'contactno', 'phone', 'mobile'],

            // Location Information
            'street_1' => ['street_1', 'street1', 'street_one'],
            'street_2' => ['street_2', 'street2', 'street_two'],
            'street_3' => ['street_3', 'street3', 'street_three'],
            'street_4' => ['street_4', 'street4', 'street_four'],
            'geyser_point' => ['geyser_point', 'geyserpoint', 'geyser'],
            'extra_kitchen' => ['extra_kitchen', 'extrakitchen', 'kitchen'],
            'sla_days' => ['sla_days', 'sladays', 'sla'],
            'connections_status' => ['connections_status', 'connectionsstatus', 'status'],

            // Technical Information
            'plb_name' => ['plb_name', 'plbname', 'plumber_name', 'plumbername'],
            'plb_date' => ['plb_date', 'plbdate', 'plumber_date', 'plumbing_date'],
            'pdt_date' => ['pdt_date', 'pdtdate', 'pdt_dt'],
            'pdt_tpi' => ['pdt_tpi', 'pdttpi'],
            'gc_date' => ['gc_date', 'gcdate', 'gc_dt'],
            'gc_tpi' => ['gc_tpi', 'gctpi'],
            'mmt_date' => ['mmt_date', 'mmtdate', 'mmt_dt'],
            'mmt_tpi' => ['mmt_tpi', 'mmttpi'],
            'conversion_date' => ['conversion_date', 'conversiondate', 'conversion_dt'],
            'conversion_technician' => ['conversion_technician', 'conversiontechnician', 'conversion_tech'],
            'conversion_payment' => ['conversion_payment', 'conversionpayment', 'conv_payment'],
            'meter_number' => ['meter_number', 'meternumber', 'meter_no'],
            'meter_reading' => ['meter_reading', 'meterreading'],
            'plumber' => ['plumber', 'plumber_name', 'plumbername'],
            'witnesses_name_date' => ['witnesses_name_date', 'witnessesnamedate', 'witnesses_name_&_date'],
            'witnesses_name_date_2' => ['witnesses_name_date_2', 'witnessesnamedate2', 'witnesses_name_&_date_2'],
            'date_of_report' => ['date_of_report', 'dateofreport', 'report_date'],
            'reported' => ['reported', 'report_status'],

            // Measurement Fields
            'gi_guard_to_main_valve_half_inch' => ['gi_guard_to_main_valve_half_inch', 'gi_guard_to_main_valve_1/2"', 'gi_guard_to_main_valve_1/2', 'gi_guard_to_main_valve_12'],
            'gi_main_valve_to_meter_half_inch' => ['gi_main_valve_to_meter_half_inch', 'gi_main_valve_to_meter_1/2"', 'gi_main_valve_to_meter_1/2', 'gi_main_valve_to_meter_12'],
            'gi_meter_to_geyser_half_inch' => ['gi_meter_to_geyser_half_inch', 'gi_meter_to_geyser_1/2"', 'gi_meter_to_geyser_1/2', 'gi_meter_to_geyser_12'],
            'gi_geyser_point_half_inch' => ['gi_geyser_point_half_inch', 'gi_geyser_point_1/2"', 'gi_geyser_point_1/2', 'gi_geyser_point_12'],
            'extra_kitchen_point' => ['extra_kitchen_point', 'extrakitchenpoint'],
            'total_gi' => ['total_gi', 'totalgi'],

            // Regulators and Components
            'high_press_1_6_reg' => ['high_press_1_6_reg', 'high_press_16_reg', 'highpress16reg'],
            'low_press_2_5_reg' => ['low_press_2_5_reg', 'low_press_25_reg', 'lowpress25reg'],
            'reg_qty' => ['reg_qty', 'regqty', 'regulator_quantity'],
            'gas_tap' => ['gas_tap', 'gastap'],
            'valve_half_inch' => ['valve_half_inch', 'valve_1/2"', 'valve_1/2', 'valve_12'],
            'gi_coupling_half_inch' => ['gi_coupling_half_inch', 'gi_coupling_1/2"', 'gi_coupling_1/2', 'gi_coupling_12'],
            'gi_elbow_half_inch' => ['gi_elbow_half_inch', 'gi_elbow_1/2"', 'gi_elbow_1/2', 'gi_elbow_12'],
            'clamp_half_inch' => ['clamp_half_inch', 'clamp_1/2"', 'clamp_1/2', 'clamp_12'],
            'gi_tee_half_inch' => ['gi_tee_half_inch', 'gi_tee_1/2"', 'gi_tee_1/2', 'gi_tee_12'],
            'anaconda' => ['anaconda'],

            // Pipe and Excavation
            'open_cut_20mm' => ['open_cut_20mm', 'opencut20mm', 'open_cut_20'],
            'boring_20mm' => ['boring_20mm', 'boring20mm', 'boring_20'],
            'total_mdpe_pipe_20mm' => ['total_mdpe_pipe_20mm', 'totalmdpepipe20mm', 'total_mdpe_20mm'],
            'tee_20mm' => ['tee_20mm', 'tee20mm', 'tee_20'],
            'rcc_guard_20mm' => ['rcc_guard_20mm', 'rccguard20mm', 'rcc_guard_20'],

            // GF Components
            'gf_coupler_20mm' => ['gf_coupler_20mm', 'gfcoupler20mm', 'gf_coupler_20'],
            'gf_saddle_32x20mm' => ['gf_saddle_32x20mm', 'gfsaddle32x20mm', 'gf_saddle_32x20'],
            'gf_saddle_63x20mm' => ['gf_saddle_63x20mm', 'gfsaddle63x20mm', 'gf_saddle_63x20'],
            'gf_saddle_63x32mm' => ['gf_saddle_63x32mm', 'gfsaddle63x32mm', 'gf_saddle_63x32'],
            'gf_saddle_125x32' => ['gf_saddle_125x32', 'gfsaddle125x32', 'gf_saddle_125x32mm'],
            'gf_saddle_90x20mm' => ['gf_saddle_90x20mm', 'gfsaddle90x20mm', 'gf_saddle_90x20'],
            'gf_reducer_32x20mm' => ['gf_reducer_32x20mm', 'gfreducer32x20mm', 'gf_reducer_32x20'],

            // Administrative
            'nepl_claim' => ['nepl_claim', 'neplclaim'],
            'offline_drawing' => ['offline_drawing', 'offlinedrawing'],
            'gc_done_by' => ['gc_done_by', 'gcdoneby'],
            'v_lookup' => ['v_lookup', 'vlookup'],
            'ra_bill_no' => ['ra_bill_no', 'ra_bill_number', 'rabillno', 'bill_no'],
            'current_remarks' => ['current_remarks', 'currentremarks'],
            'previous_remarks' => ['previous_remarks', 'previousremarks'],
            'remarks' => ['remarks', 'general_remarks', 'comments'],
        ];

        $mapped = [];
        
        foreach ($mappings as $targetField => $possibleKeys) {
            $value = null;
            foreach ($possibleKeys as $key) {
                if (array_key_exists($key, $row)) {
                    $value = $row[$key];
                    break;
                }
            }
            // Always set the field, even if value is null
            $mapped[$targetField] = $value;
        }

        return $mapped;
    }

    /**
     * Process and convert data types - handle nulls properly
     */
    private function processDataTypes(array $data): array
    {
        // Convert and validate dates
        $dateFields = ['agreement_date', 'start_date', 'plb_date', 'pdt_date', 'gc_date', 'mmt_date', 'conversion_date', 'date_of_report'];
        foreach ($dateFields as $field) {
            $data[$field] = $this->convertExcelDate($data[$field] ?? null);
        }

        // Normalize plan type specifically
        if (isset($data['plan_type'])) {
            $data['plan_type'] = $this->normalizePlanType($data['plan_type']);
        }

        // Convert numeric fields - keep null if empty
        $numericFields = [
            'geyser_point', 'extra_kitchen', 'sla_days',
            'high_press_1_6_reg', 'low_press_2_5_reg', 'reg_qty', 'gas_tap',
            'valve_half_inch', 'gi_coupling_half_inch', 'gi_elbow_half_inch',
            'clamp_half_inch', 'gi_tee_half_inch', 'anaconda',
            'tee_20mm', 'rcc_guard_20mm', 'gf_coupler_20mm',
            'gf_saddle_32x20mm', 'gf_saddle_63x20mm', 'gf_saddle_63x32mm',
            'gf_saddle_125x32', 'gf_saddle_90x20mm', 'gf_reducer_32x20mm'
        ];
        
        foreach ($numericFields as $field) {
            $data[$field] = $this->parseNumeric($data[$field] ?? null);
        }

        // Convert decimal fields - keep null if empty
        $decimalFields = [
            'gi_guard_to_main_valve_half_inch', 'gi_main_valve_to_meter_half_inch',
            'gi_meter_to_geyser_half_inch', 'gi_geyser_point_half_inch',
            'extra_kitchen_point', 'total_gi', 'open_cut_20mm', 'boring_20mm',
            'total_mdpe_pipe_20mm', 'conversion_payment', 'meter_reading'
        ];
        
        foreach ($decimalFields as $field) {
            $data[$field] = $this->parseDecimal($data[$field] ?? null);
        }

        // Ensure string fields are properly handled
        $stringFields = [
            'po_number', 'service_order_no', 'booking_by', 'customer',
            'customer_name', 'customer_no', 'application_no', 'notification_numbers',
            'house_no', 'customer_contact_no', 'street_1', 'street_2', 'street_3',
            'street_4', 'connections_status', 'plb_name', 'pdt_tpi', 'gc_tpi',
            'mmt_tpi', 'conversion_technician', 'meter_number', 'plumber',
            'witnesses_name_date', 'witnesses_name_date_2', 'reported',
            'nepl_claim', 'offline_drawing', 'gc_done_by', 'v_lookup',
            'ra_bill_no', 'current_remarks', 'previous_remarks', 'remarks'
        ];
        
        foreach ($stringFields as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = $this->sanitizeString($data[$field]);
            }
        }

        // Remove any fields that don't exist in the database to avoid column mismatch
        $validFields = [
            'po_number', 'service_order_no', 'agreement_date', 'booking_by', 'start_date',
            'plan_type', 'customer_name', 'customer_no', 'application_no', 'notification_numbers',
            'house_no', 'customer_contact_no', 'street_1', 'street_2', 'street_3', 'street_4',
            'geyser_point', 'extra_kitchen', 'sla_days', 'connections_status', 'plb_name',
            'plb_date', 'pdt_date', 'pdt_tpi', 'gc_date', 'gc_tpi', 'mmt_date', 'mmt_tpi',
            'conversion_date', 'conversion_technician', 'conversion_payment', 'meter_number',
            'meter_reading', 'plumber', 'witnesses_name_date', 'witnesses_name_date_2',
            'date_of_report', 'reported', 'gi_guard_to_main_valve_half_inch',
            'gi_main_valve_to_meter_half_inch', 'gi_meter_to_geyser_half_inch',
            'gi_geyser_point_half_inch', 'extra_kitchen_point', 'total_gi',
            'high_press_1_6_reg', 'low_press_2_5_reg', 'reg_qty', 'gas_tap',
            'valve_half_inch', 'gi_coupling_half_inch', 'gi_elbow_half_inch',
            'clamp_half_inch', 'gi_tee_half_inch', 'anaconda', 'open_cut_20mm',
            'boring_20mm', 'total_mdpe_pipe_20mm', 'tee_20mm', 'rcc_guard_20mm',
            'gf_coupler_20mm', 'gf_saddle_32x20mm', 'gf_saddle_63x20mm',
            'gf_saddle_63x32mm', 'gf_saddle_125x32', 'gf_saddle_90x20mm',
            'gf_reducer_32x20mm', 'nepl_claim', 'offline_drawing', 'gc_done_by',
            'v_lookup', 'ra_bill_no', 'current_remarks', 'previous_remarks', 'remarks',
            'customer' // Add customer field to avoid the error
        ];

        $filteredData = [];
        foreach ($validFields as $field) {
            $filteredData[$field] = $data[$field] ?? null;
        }

        // Set customer field as fallback for customer_name
        if (empty($filteredData['customer']) && !empty($filteredData['customer_name'])) {
            $filteredData['customer'] = $filteredData['customer_name'];
        }

        return $filteredData;
    }

    /**
     * Sanitize string values - handle empty values properly
     */
    private function sanitizeString($value)
    {
        if (is_null($value)) {
            return null;
        }
        
        $value = trim((string) $value);
        
        // Convert various empty representations to null
        if ($value === '' || $value === '?' || $value === '-' || strtolower($value) === 'null' || strtolower($value) === 'n/a') {
            return null;
        }
        
        return $value;
    }

    /**
     * Normalize plan type to match database enum values
     */
    private function normalizePlanType($planType)
    {
        if (is_null($planType) || $planType === '' || $planType === '?' || $planType === '-') {
            return null;
        }
        
        // Convert to lowercase and remove extra spaces
        $planType = strtolower(trim($planType));
        
        // Define mapping from Excel values to database enum values
        $mapping = [
            // Apartment variations
            'apartment' => 'apartment',
            'apartments' => 'apartment',
            'apt' => 'apartment',
            'flat' => 'apartment',
            'flats' => 'apartment',
            
            // Bungalow variations  
            'bungalow' => 'bungalow',
            'bunglow' => 'bungalow',  // Common misspelling
            'bunglows' => 'bungalow',
            'bungalows' => 'bungalow',
            'banglow' => 'bungalow',   // Another misspelling
            'villa' => 'bungalow',
            
            // Rowhouse variations
            'rowhouse' => 'rowhouse',
            'row house' => 'rowhouse',
            'row_house' => 'rowhouse',
            'row-house' => 'rowhouse',
            'townhouse' => 'rowhouse',
            'town house' => 'rowhouse',
            
            // Individual variations
            'individual' => 'individual',
            'independent' => 'individual',
            'standalone' => 'individual',
            'single' => 'individual',
            
            // Commercial variations
            'commercial' => 'commercial',
            'business' => 'commercial',
            'office' => 'commercial',
            'shop' => 'commercial',
            'retail' => 'commercial',
            
            // Farmhouse variations
            'farmhouse' => 'farmhouse',
            'farm house' => 'farmhouse',
            'farm_house' => 'farmhouse',
            'farm-house' => 'farmhouse',
            
            // Other common variations
            'ggl' => 'individual', // Based on your data, GGL seems to be individual
            'domestic' => 'individual',
            'residential' => 'individual',
        ];
        
        // Check if the plan type exists in our mapping
        if (array_key_exists($planType, $mapping)) {
            return $mapping[$planType];
        }
        
        // If no exact match, try partial matching
        foreach ($mapping as $key => $value) {
            if (strpos($planType, $key) !== false || strpos($key, $planType) !== false) {
                return $value;
            }
        }
        
        // Log unrecognized plan types for debugging
        Log::warning('Unrecognized plan type in import: ' . $planType);
        
        // Return the original value as lowercase if no mapping found
        // This will cause a database constraint error if it's not valid
        return $planType;
    }

    /**
     * Convert Excel date to proper format - handle nulls
     */
    private function convertExcelDate($value)
    {
        if (is_null($value) || $value === '') {
            return null;
        }

        try {
            // If it's already a valid date string
            if (is_string($value) && strtotime($value) !== false) {
                return Carbon::parse($value)->format('Y-m-d');
            }

            // If it's an Excel serial date number
            if (is_numeric($value)) {
                // Excel dates start from 1900-01-01, but Excel incorrectly treats 1900 as a leap year
                $unixDate = ($value - 25569) * 86400;
                return Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
            }

            return null;
        } catch (\Exception $e) {
            Log::warning('Date conversion failed: ' . $e->getMessage(), ['value' => $value]);
            return null;
        }
    }

    /**
     * Parse numeric values safely - return null for empty
     */
    private function parseNumeric($value)
    {
        if (is_null($value) || $value === '' || !is_numeric($value)) {
            return null;
        }
        return (int) $value;
    }

    /**
     * Parse decimal values safely - return null for empty
     */
    private function parseDecimal($value)
    {
        if (is_null($value) || $value === '' || !is_numeric($value)) {
            return null;
        }
        return (float) $value;
    }

    /**
     * Set batch size for bulk inserts
     */
    public function batchSize(): int
    {
        return 50; // Reduced for better error handling
    }

    /**
     * Set chunk size for reading large files
     */
    public function chunkSize(): int
    {
        return 100; // Reduced for better error handling
    }

    /**
     * Handle import errors
     */
    public function onError(Throwable $e)
    {
        $this->errors[] = "Import error: " . $e->getMessage();
        Log::error('PNG Import Error: ' . $e->getMessage());
    }

    /**
     * Handle validation failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
        }
    }

    /**
     * Get import summary
     */
    public function getImportSummary(): array
    {
        return [
            'success_count' => $this->successCount,
            'update_count' => $this->updateCount,
            'skip_count' => $this->skipCount,
            'error_count' => count($this->errors),
            'errors' => $this->errors
        ];
    }
}