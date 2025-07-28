<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\PeTracker;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class PeTrackerImport implements ToModel, WithHeadingRow, WithValidation
{
   /**
     * Transform each row into a model.
     */
    public function model(array $row)
    {
        // Parse date
        $date = $this->parseDate($row['date'] ?? null);
        
        // Organize measurements
        $measurements = $this->organizeMeasurements($row);
        
        // Organize installation data
        $installationData = $this->organizeInstallationData($row);
        
        // Organize pipe fittings
        $pipeFittings = $this->organizePipeFittings($row);
        
        // Organize testing data
        $testingData = $this->organizeTestingData($row);
        
        $peTracker = new PeTracker([
            'date' => $date,
            'dpr_no' => $row['dpr_no'] ?? null,
            'sites_names' => $row['sites_names'] ?? '',
            'activity' => $this->normalizeActivity($row['activity'] ?? ''),
            'mukadam_name' => $row['mukadam_name'] ?? null,
            'supervisor' => $row['supervisor'] ?? null,
            'tpi_name' => $row['tpi_name'] ?? null,
            'ra_bill_no' => $row['ra_bill_no'] ?? null,
            'measurements' => $measurements,
            'installation_data' => $installationData,
            'pipe_fittings' => $pipeFittings,
            'testing_data' => $testingData,
            'project_status' => 'active'
        ]);
        
        // Calculate total laying length
        $peTracker->total_laying_length = $this->calculateTotalLaying($measurements);
        
        return $peTracker;
    }

    /**
     * Validation rules for import.
     */
    public function rules(): array
    {
        return [
            'date' => 'required',
            'sites_names' => 'required|string',
            'activity' => 'required|string',
        ];
    }

    /**
     * Parse date from various formats.
     */
    private function parseDate($dateValue)
    {
        if (empty($dateValue)) {
            return now();
        }

        // If it's already a Carbon instance
        if ($dateValue instanceof Carbon) {
            return $dateValue;
        }

        // If it's a numeric Excel date
        if (is_numeric($dateValue)) {
            return Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateValue)->format('Y-m-d'));
        }

        // Try to parse as string
        try {
            return Carbon::createFromFormat('d-M-y', $dateValue) ?: 
                   Carbon::createFromFormat('d-m-Y', $dateValue) ?: 
                   Carbon::createFromFormat('Y-m-d', $dateValue) ?: 
                   Carbon::parse($dateValue);
        } catch (\Exception $e) {
            return now();
        }
    }

    /**
     * Normalize activity values.
     */
    private function normalizeActivity($activity)
    {
        $activity = strtoupper(trim($activity));
        
        $validActivities = ['LAYING', 'COMMISSIONING', 'EXCAVATION', 'FLUSHING', 'JOINT', 'SR INSTALLATION'];
        
        return in_array($activity, $validActivities) ? $activity : 'LAYING';
    }

    /**
     * Organize measurements from Excel row.
     */
    private function organizeMeasurements($row)
    {
        $measurements = [];
        
        $measurementFields = [
            '32_mm_laying_open_cut',
            '63_mm_laying_open_cut',
            '90_mm_laying_open_cut',
            '125_mm_laying_open_cut',
            '32_mm_manual_boring',
            '63_mm_manual_boring',
            '90_mm_manual_boring',
            '125_mm_manual_boring',
            '32_mm_manual_boring_casing_50mm',
            '63_mm_manual_boring_casing_90mm',
            '90_mm_manual_boring_casing_125mm',
            '125_mm_manual_boring_casing_160mm',
            'breaking_hard_rock_completion',
            'excavation_beyond_2m_depth',
            'breaking_hard_surface_cutter_brea_ker',
            'rcc_cutting_breaking_150',
            'pcc_cutting_breaking_150'
        ];
        
        foreach ($measurementFields as $field) {
            $value = $this->getNumericValue($row, $field);
            if ($value > 0) {
                $measurements[$field] = $value;
            }
        }
        
        return $measurements;
    }

    /**
     * Organize installation data from Excel row.
     */
    private function organizeInstallationData($row)
    {
        $installation = [];
        
        $installationFields = [
            'restoration_asphalted_surface',
            'restoration_cement_concrete',
            'restoration_tiles_pb_kerstone_brick',
            'restoration_reinforced_cement_concrete',
            'const_supply_installation_vc',
            'installation_sr_5_regulator',
            'installation_of_5_srm',
            'installation_of_b_10_srm',
            'installation_of_b_25_srm',
            'installation_of_b_50_srm',
            'installation_of_b_100_srm'
        ];
        
        foreach ($installationFields as $field) {
            $value = $this->getNumericValue($row, $field);
            if ($value > 0) {
                $installation[$field] = $value;
            }
        }
        
        return $installation;
    }

    /**
     * Organize pipe fittings from Excel row.
     */
    private function organizePipeFittings($row)
    {
        $pipeFittings = [];
        
        $pipeFittingFields = [
            'supply_install_route_markers_type_b',
            'supply_install_markers_type_b',
            'hard_barricading_for_mp_pipeline',
            'barricating_for_lp_pipeline',
            'liasoning_statutory_conc_ern_authorities',
            'pcc_124_by_mass',
            'pcc_148_by_mass',
            'rcc_of_grade_m20',
            'rcc_of_grade_m25',
            'brick_work_m75_cement_mortar_134',
            'rcc_of_grade_m25_for_drain_cross_over',
            'pe_service_lines_of_cut_20mm'
        ];
        
        foreach ($pipeFittingFields as $field) {
            $value = $this->getNumericValue($row, $field);
            if ($value > 0) {
                $pipeFittings[$field] = $value;
            }
        }
        
        return $pipeFittings;
    }

    /**
     * Organize testing data from Excel row.
     */
    private function organizeTestingData($row)
    {
        $testing = [];
        
        // Numeric testing fields
        $numericTestingFields = [
            'additional_point_customer_request',
            'installation_test_com_mission_upto_g10',
            'installation_test_com_mission_above_g10',
            'industrial_hookup_upto_2_inlet',
            'industrial_hookup_4_inlet',
            'industrial_hookup_with_drs',
            '20mm_ec',
            '32mm_ec',
            '63mm_ec',
            '90mm_ec',
            '125mm_ec',
            '32mm_elbow',
            '63mm_elbow'
        ];
        
        foreach ($numericTestingFields as $field) {
            $value = $this->getNumericValue($row, $field);
            if ($value > 0) {
                $testing[$field] = $value;
            }
        }
        
        // Text testing fields
        $textTestingFields = [
            'flushing_testing_done',
            'commissioning'
        ];
        
        foreach ($textTestingFields as $field) {
            $value = $row[$field] ?? null;
            if (!empty($value) && $value !== '') {
                $testing[$field] = trim($value);
            }
        }
        
        return $testing;
    }

    /**
     * Get numeric value from row with various possible formats.
     */
    private function getNumericValue($row, $field)
    {
        $value = $row[$field] ?? 0;
        
        if (is_numeric($value)) {
            return (float) $value;
        }
        
        // Try to extract numeric value from string
        $numericValue = preg_replace('/[^0-9.]/', '', $value);
        return is_numeric($numericValue) ? (float) $numericValue : 0;
    }

    /**
     * Calculate total laying length from measurements.
     */
    private function calculateTotalLaying($measurements)
    {
        $total = 0;
        $layingFields = [
            '32_mm_laying_open_cut',
            '63_mm_laying_open_cut', 
            '90_mm_laying_open_cut',
            '125_mm_laying_open_cut',
            '32_mm_manual_boring',
            '63_mm_manual_boring',
            '90_mm_manual_boring',
            '125_mm_manual_boring'
        ];
        
        foreach ($layingFields as $field) {
            $total += $measurements[$field] ?? 0;
        }
        
        return $total;
    }
}
