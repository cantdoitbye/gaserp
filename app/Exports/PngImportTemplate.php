<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PngImportTemplate implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    /**
     * Return sample data
     */
    public function array(): array
    {
        // Return sample data with proper formatting
        return [
            [
                // Basic Information
                'PNG001', // po_number
                'SO12345', // service_order_no
                '2024-01-15', // agreement_date
                'PINAL', // booking_by
                '2024-01-16', // start_date
                'domestic', // plan_type
                'John Doe', // customer_name
                'CUST001', // customer_no
                'APP001', // application_no
                'NOT001', // notification_numbers
                '123', // house_no
                '9876543210', // customer_contact_no
                
                // Location Information
                'Main Street', // street_1
                'Sector 15', // street_2
                'Phase 2', // street_3
                'Area A', // street_4
                1, // geyser_point
                1, // extra_kitchen
                30, // sla_days
                'Workable', // connections_status
                
                // Technical Information
                'Plumber Name', // plb_name
                '2024-01-20', // plb_date
                '2024-01-21', // pdt_date
                'TPI001', // pdt_tpi
                '2024-01-22', // gc_date
                'TPI002', // gc_tpi
                '2024-01-23', // mmt_date
                'TPI003', // mmt_tpi
                '2024-01-24', // conversion_date
                'Tech Name', // conversion_technician
                1500.00, // conversion_payment
                'MTR001', // meter_number
                0.25, // meter_reading
                'Main Plumber', // plumber
                'Witness 1 - 2024-01-20', // witnesses_name_date
                'Witness 2 - 2024-01-21', // witnesses_name_date_2
                '2024-01-25', // date_of_report
                'REPORTED', // reported
                
                // GI Measurements
                1.40, // gi_guard_to_main_valve_half_inch
                1.68, // gi_main_valve_to_meter_half_inch
                24.92, // gi_meter_to_geyser_half_inch
                1.70, // gi_geyser_point_half_inch
                0.10, // extra_kitchen_point
                29.80, // total_gi
                
                // Regulators and Components
                1, // high_press_1_6_reg
                1, // low_press_2_5_reg
                1, // reg_qty
                1, // gas_tap
                1, // valve_half_inch
                4, // gi_coupling_half_inch
                7, // gi_elbow_half_inch
                48, // clamp_half_inch
                1, // gi_tee_half_inch
                1, // anaconda
                
                // Pipe and Excavation
                6.10, // open_cut_20mm
                12.00, // boring_20mm
                18.10, // total_mdpe_pipe_20mm
                1, // tee_20mm
                1, // rcc_guard_20mm
                
                // GF Components
                2, // gf_coupler_20mm
                1, // gf_saddle_32x20mm
                null, // gf_saddle_63x20mm
                null, // gf_saddle_63x32mm
                null, // gf_saddle_125x32
                null, // gf_saddle_90x20mm
                null, // gf_reducer_32x20mm
                
                // Administrative
                'SRT/PNG/RA-55', // nepl_claim
                'DONE', // offline_drawing
                'DARSHAN', // gc_done_by
                '', // v_lookup
                'RA001', // ra_bill_no
                'Current status remarks', // current_remarks
                'Previous remarks', // previous_remarks
                'General remarks' // remarks
            ]
        ];
    }

    /**
     * Define column headings that match the import expectations
     */
    public function headings(): array
    {
        return [
            // Basic Information
            'PO Number',
            'Service Order No',
            'Agreement Date',
            'Booking By',
            'Start Date',
            'Activity Type',
            'Customer Name',
            'Customer No',
            'Application No',
            'Notification Numbers',
            'House No',
            'Customer Contact No',
            
            // Location Information
            'Street 1',
            'Street 2',
            'Street 3',
            'Street 4',
            'Geyser Point',
            'Extra Kitchen',
            'SLA Days',
            'Connections Status',
            
            // Technical Information
            'PLB Name',
            'PLB Date',
            'PDT Date',
            'PDT TPI',
            'GC Date',
            'GC TPI',
            'MMT Date',
            'MMT TPI',
            'Conversion Date',
            'Conversion Technician',
            'Conversion Payment',
            'Meter Number',
            'Meter Reading',
            'Plumber',
            'Witnesses Name & Date',
            'Witnesses Name & Date 2',
            'Date of Report',
            'Reported',
            
            // GI Measurements
            'GI Guard to Main Valve 1/2"',
            'GI Main Valve to Meter 1/2"',
            'GI Meter to Geyser 1/2"',
            'GI Geyser Point 1/2"',
            'Extra Kitchen Point',
            'Total GI',
            
            // Regulators and Components
            'High Press 1.6 Reg',
            'Low Press 2.5 Reg',
            'Reg Qty',
            'Gas Tap',
            'Valve 1/2"',
            'GI Coupling 1/2"',
            'GI Elbow 1/2"',
            'Clamp 1/2"',
            'GI Tee 1/2"',
            'Anaconda',
            
            // Pipe and Excavation
            'Open Cut 20mm',
            'Boring 20mm',
            'Total MDPE Pipe 20mm',
            'Tee 20mm',
            'RCC Guard 20mm',
            
            // GF Components
            'GF Coupler 20mm',
            'GF Saddle 32x20mm',
            'GF Saddle 63x20mm',
            'GF Saddle 63x32mm',
            'GF Saddle 125x32',
            'GF Saddle 90x20mm',
            'GF Reducer 32x20mm',
            
            // Administrative
            'NEPL Claim',
            'Offline Drawing',
            'GC Done By',
            'V Lookup',
            'RA Bill No',
            'Current Remarks',
            'Previous Remarks',
            'Remarks'
        ];
    }

    /**
     * Apply styles to the template
     */
    public function styles(Worksheet $sheet)
    {
        $lastColumn = $sheet->getHighestColumn();
        
        // Header row styling
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Sample data row styling
        $sheet->getStyle('A2:' . $lastColumn . '2')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E7F3FF'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Set row heights
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(25);

        // Add instructions
        // $sheet->setCellValue('A4', 'INSTRUCTIONS:');
        // $sheet->setCellValue('A5', '1. Use this exact format for importing PNG data');
        // $sheet->setCellValue('A6', '2. Date format: YYYY-MM-DD (e.g., 2024-01-15)');
        // $sheet->setCellValue('A7', '3. Decimal values: Use dots (.) not commas (,)');
        // $sheet->setCellValue('A8', '4. Required fields: Service Order No, Customer Name');
        // $sheet->setCellValue('A9', '5. Delete this sample row and instructions before importing');
        // $sheet->setCellValue('A10', '6. Keep column headers exactly as shown');

        // Style instructions
        $sheet->getStyle('A4:A10')->applyFromArray([
            'font' => [
                'italic' => true,
                'color' => ['rgb' => '666666'],
            ],
        ]);

        $sheet->getStyle('A4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
        ]);

        return $sheet;
    }

    /**
     * Set column widths for better readability
     */
    public function columnWidths(): array
    {
        return [
            'A' => 12,  // PO Number
            'B' => 15,  // Service Order No
            'C' => 13,  // Agreement Date
            'D' => 12,  // Booking By
            'E' => 12,  // Start Date
            'F' => 12,  // Plan Type
            'G' => 20,  // Customer Name
            'H' => 12,  // Customer No
            'I' => 15,  // Application No
            'J' => 18,  // Notification Numbers
            'K' => 10,  // House No
            'L' => 15,  // Customer Contact No
            'M' => 15,  // Street 1
            'N' => 15,  // Street 2
            'O' => 15,  // Street 3
            'P' => 15,  // Street 4
            'Q' => 12,  // Geyser Point
            'R' => 12,  // Extra Kitchen
            'S' => 10,  // SLA Days
            'T' => 18,  // Connections Status
            'U' => 15,  // PLB Name
            'V' => 12,  // PLB Date
            'W' => 12,  // PDT Date
            'X' => 10,  // PDT TPI
            'Y' => 12,  // GC Date
            'Z' => 10,  // GC TPI
            'AA' => 12, // MMT Date
            'AB' => 10, // MMT TPI
            'AC' => 15, // Conversion Date
            'AD' => 18, // Conversion Technician
            'AE' => 15, // Conversion Payment
            'AF' => 12, // Meter Number
            'AG' => 12, // Meter Reading
            'AH' => 15, // Plumber
            'AI' => 20, // Witnesses Name & Date
            'AJ' => 20, // Witnesses Name & Date 2
            'AK' => 15, // Date of Report
            'AL' => 10, // Reported
            'AM' => 20, // GI Guard to Main Valve
            'AN' => 20, // GI Main Valve to Meter
            'AO' => 20, // GI Meter to Geyser
            'AP' => 18, // GI Geyser Point
            'AQ' => 18, // Extra Kitchen Point
            'AR' => 12, // Total GI
            'AS' => 15, // High Press 1.6 Reg
            'AT' => 15, // Low Press 2.5 Reg
            'AU' => 10, // Reg Qty
            'AV' => 10, // Gas Tap
            'AW' => 12, // Valve 1/2"
            'AX' => 15, // GI Coupling 1/2"
            'AY' => 12, // GI Elbow 1/2"
            'AZ' => 12, // Clamp 1/2"
            'BA' => 12, // GI Tee 1/2"
            'BB' => 12, // Anaconda
            'BC' => 15, // Open Cut 20mm
            'BD' => 12, // Boring 20mm
            'BE' => 18, // Total MDPE Pipe 20mm
            'BF' => 12, // Tee 20mm
            'BG' => 15, // RCC Guard 20mm
            'BH' => 15, // GF Coupler 20mm
            'BI' => 18, // GF Saddle 32x20mm
            'BJ' => 18, // GF Saddle 63x20mm
            'BK' => 18, // GF Saddle 63x32mm
            'BL' => 15, // GF Saddle 125x32
            'BM' => 18, // GF Saddle 90x20mm
            'BN' => 18, // GF Reducer 32x20mm
            'BO' => 15, // NEPL Claim
            'BP' => 15, // Offline Drawing
            'BQ' => 15, // GC Done By
            'BR' => 12, // V Lookup
            'BS' => 15, // RA Bill No
            'BT' => 25, // Current Remarks
            'BU' => 25, // Previous Remarks
            'BV' => 25, // Remarks
        ];
    }

    /**
     * Set worksheet title
     */
    public function title(): string
    {
        return 'PNG Import Template';
    }
}