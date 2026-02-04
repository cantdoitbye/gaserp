<?php

namespace App\Exports;

use App\Models\Png;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PngExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Query to get PNG data
     */
    public function query()
    {
        $query = Png::query();

        // Apply filters if provided
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('service_order_no', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_no', 'like', "%{$search}%")
                  ->orWhere('po_number', 'like', "%{$search}%")
                  ->orWhere('house_no', 'like', "%{$search}%")
                  ->orWhere('application_no', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['connections_status'])) {
            $query->where('connections_status', $this->filters['connections_status']);
        }

        if (!empty($this->filters['plan_type'])) {
            $query->where('plan_type', $this->filters['plan_type']);
        }

        if (!empty($this->filters['booking_by'])) {
            $query->where('booking_by', $this->filters['booking_by']);
        }

        if (!empty($this->filters['start_date_from'])) {
            $query->where('start_date', '>=', $this->filters['start_date_from']);
        }

        if (!empty($this->filters['start_date_to'])) {
            $query->where('start_date', '<=', $this->filters['start_date_to']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Map each row of data
     */
    public function map($png): array
    {
        return [
            // Basic Information
            $png->po_number,
            $png->service_order_no,
            $png->agreement_date ? $png->agreement_date->format('Y-m-d') : '',
            $png->booking_by,
            $png->start_date ? $png->start_date->format('Y-m-d') : '',
            $png->plan_type,
            $png->customer,
            $png->customer_no,
            $png->customer_name,
            $png->application_no,
            $png->notification_numbers,
            $png->house_no,
            $png->customer_contact_no,
            
            // Location Information
            $png->street_1,
            $png->street_2,
            $png->street_3,
            $png->street_4,
            $png->geyser_point,
            $png->extra_kitchen,
            $png->sla_days,
            $png->connections_status,
            
            // Technical Information
            $png->plb_name,
            $png->plb_date ? $png->plb_date->format('Y-m-d') : '',
            $png->pdt_date ? $png->pdt_date->format('Y-m-d') : '',
            $png->pdt_tpi,
            $png->gc_date ? $png->gc_date->format('Y-m-d') : '',
            $png->gc_tpi,
            $png->mmt_date ? $png->mmt_date->format('Y-m-d') : '',
            $png->mmt_tpi,
            $png->conversion_date ? $png->conversion_date->format('Y-m-d') : '',
            $png->conversion_technician,
            $png->conversion_payment,
            $png->meter_number,
            $png->meter_reading,
            $png->plumber,
            $png->witnesses_name_date,
            $png->witnesses_name_date_2,
            $png->date_of_report ? $png->date_of_report->format('Y-m-d') : '',
            $png->reported,
            
            // GI (Galvanized Iron) Measurements
            $png->gi_guard_to_main_valve_half_inch,
            $png->gi_main_valve_to_meter_half_inch,
            $png->gi_meter_to_geyser_half_inch,
            $png->gi_geyser_point_half_inch,
            $png->extra_kitchen_point,
            $png->total_gi,
            
            // Regulators and Components
            $png->high_press_1_6_reg,
            $png->low_press_2_5_reg,
            $png->reg_qty,
            $png->gas_tap,
            $png->valve_half_inch,
            $png->gi_coupling_half_inch,
            $png->gi_elbow_half_inch,
            $png->clamp_half_inch,
            $png->gi_tee_half_inch,
            $png->anaconda,
            
            // Pipe and Excavation
            $png->open_cut_20mm,
            $png->boring_20mm,
            $png->total_mdpe_pipe_20mm,
            $png->tee_20mm,
            $png->rcc_guard_20mm,
            
            // GF (Gas Fittings) Components
            $png->gf_coupler_20mm,
            $png->gf_saddle_32x20mm,
            $png->gf_saddle_63x20mm,
            $png->gf_saddle_63x32mm,
            $png->gf_saddle_125x32,
            $png->gf_saddle_90x20mm,
            $png->gf_reducer_32x20mm,
            
            // Administrative
            $png->nepl_claim,
            $png->offline_drawing,
            $png->gc_done_by,
            $png->v_lookup,
            $png->ra_bill_no,
            $png->current_remarks,
            $png->previous_remarks,
            $png->remarks,
            
            // Timestamps
            $png->created_at ? $png->created_at->format('Y-m-d H:i:s') : '',
            $png->updated_at ? $png->updated_at->format('Y-m-d H:i:s') : '',
        ];
    }

    /**
     * Define column headings
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
            'Plan Type',
            'Customer',
            'Customer No',
            'Customer Name',
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
            
            // GI (Galvanized Iron) Measurements
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
            
            // GF (Gas Fittings) Components
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
            'Remarks',
            
            // Timestamps
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Apply styles to the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        // Get the last column letter
        $lastColumn = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();

        // Header row styling
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2E86AB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Data rows styling
        if ($lastRow > 1) {
            $sheet->getStyle('A2:' . $lastColumn . $lastRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Alternate row colors
            for ($row = 2; $row <= $lastRow; $row++) {
                if ($row % 2 == 0) {
                    $sheet->getStyle('A' . $row . ':' . $lastColumn . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F8F9FA'],
                        ],
                    ]);
                }
            }
        }

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Auto-size columns for better readability
        // Auto-size columns for better readability
        $currentColumn = 'A';
        while ($currentColumn !== $lastColumn) {
            $sheet->getColumnDimension($currentColumn)->setAutoSize(true);
            $currentColumn++;
        }
        // Handle the last column
        $sheet->getColumnDimension($lastColumn)->setAutoSize(true);

        // Freeze header row
        $sheet->freezePane('A2');

        return $sheet;
    }

    /**
     * Set column widths
     */
    public function columnWidths(): array
    {
        return [
            'A' => 15,  // PO Number
            'B' => 20,  // Service Order No
            'C' => 15,  // Agreement Date
            'D' => 15,  // Booking By
            'E' => 15,  // Start Date
            'F' => 15,  // Plan Type
            'G' => 20,  // Customer
            'H' => 15,  // Customer No
            'I' => 25,  // Customer Name
            'J' => 20,  // Application No
            'K' => 20,  // Notification Numbers
            'L' => 15,  // House No
            'M' => 18,  // Customer Contact No
            'N' => 20,  // Street 1
            'O' => 20,  // Street 2
            'P' => 20,  // Street 3
            'Q' => 20,  // Street 4
            'R' => 12,  // Geyser Point
            'S' => 12,  // Extra Kitchen
            'T' => 10,  // SLA Days
            'U' => 18,  // Connections Status
            'V' => 20,  // PLB Name
            'W' => 15,  // PLB Date
            'X' => 15,  // PDT Date
            'Y' => 15,  // PDT TPI
            'Z' => 15,  // GC Date
            'AA' => 15, // GC TPI
            'AB' => 15, // MMT Date
            'AC' => 15, // MMT TPI
            'AD' => 15, // Conversion Date
            'AE' => 20, // Conversion Technician
            'AF' => 15, // Conversion Payment
            'AG' => 15, // Meter Number
            'AH' => 15, // Meter Reading
            'AI' => 15, // Plumber
            'AJ' => 25, // Witnesses Name & Date
            'AK' => 25, // Witnesses Name & Date 2
            'AL' => 15, // Date of Report
            'AM' => 12, // Reported
            'AN' => 20, // GI Guard to Main Valve 1/2"
            'AO' => 20, // GI Main Valve to Meter 1/2"
            'AP' => 20, // GI Meter to Geyser 1/2"
            'AQ' => 18, // GI Geyser Point 1/2"
            'AR' => 18, // Extra Kitchen Point
            'AS' => 15, // Total GI
            'AT' => 15, // High Press 1.6 Reg
            'AU' => 15, // Low Press 2.5 Reg
            'AV' => 12, // Reg Qty
            'AW' => 12, // Gas Tap
            'AX' => 12, // Valve 1/2"
            'AY' => 15, // GI Coupling 1/2"
            'AZ' => 15, // GI Elbow 1/2"
            'BA' => 12, // Clamp 1/2"
            'BB' => 12, // GI Tee 1/2"
            'BC' => 12, // Anaconda
            'BD' => 15, // Open Cut 20mm
            'BE' => 15, // Boring 20mm
            'BF' => 18, // Total MDPE Pipe 20mm
            'BG' => 12, // Tee 20mm
            'BH' => 15, // RCC Guard 20mm
            'BI' => 15, // GF Coupler 20mm
            'BJ' => 18, // GF Saddle 32x20mm
            'BK' => 18, // GF Saddle 63x20mm
            'BL' => 18, // GF Saddle 63x32mm
            'BM' => 18, // GF Saddle 125x32
            'BN' => 18, // GF Saddle 90x20mm
            'BO' => 18, // GF Reducer 32x20mm
            'BP' => 15, // NEPL Claim
            'BQ' => 15, // Offline Drawing
            'BR' => 15, // GC Done By
            'BS' => 12, // V Lookup
            'BT' => 15, // RA Bill No
            'BU' => 30, // Current Remarks
            'BV' => 30, // Previous Remarks
            'BW' => 30, // Remarks
            'BX' => 20, // Created At
            'BY' => 20, // Updated At
        ];
    }

    /**
     * Set worksheet title
     */
    public function title(): string
    {
        return 'PNG Data Export';
    }
}