<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Png;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;

class PngExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    use Exportable;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Query for export
     */
    public function query()
    {
        $query = Png::query();

        // Apply the same filters as in the index method
        if ($this->request->filled('plan_type')) {
            $query->where('plan_type', $this->request->input('plan_type'));
        }

        if ($this->request->filled('pe_status')) {
            $query->where('pe_status', $this->request->input('pe_status'));
        }

        if ($this->request->filled('reported')) {
            $query->where('reported', $this->request->input('reported'));
        }

        if ($this->request->filled('plumber')) {
            $query->where('plumber', $this->request->input('plumber'));
        }

        if ($this->request->filled('gc_tpi')) {
            $query->where('gc_tpi', $this->request->input('gc_tpi'));
        }

        if ($this->request->filled('start_date_from') && $this->request->filled('start_date_to')) {
            $query->whereBetween('start_date', [$this->request->input('start_date_from'), $this->request->input('start_date_to')]);
        }

        return $query->latest();
    }

    /**
     * Column headings
     */
    public function headings(): array
    {
        return [
            'PO Number',
            'Service Order No',
            'Agreement Date',
            'Booking By',
            'Start Date',
            'Plan Type',
            'Customer',
            'Application No',
            'Notification Numbers',
            'Customer Name',
            'House No',
            'Street 1',
            'Street 2',
            'Street 3',
            'Street 4',
            'Customer Contact No',
            'Geyser Point',
            'Extra Kitchen',
            'SLA Days',
            'Current Remarks',
            'Witnesses Name & Date',
            'Previous Remarks',
            'Witnesses Name & Date 2',
            'Reported',
            'PLB Name',
            'PLB Date',
            'PDT Date',
            'PDT TPI',
            'PE Status',
            'GC Date',
            'GC TPI',
            'MMT Date',
            'MMT TPI',
            'Conversion Date',
            'Conversion Technician',
            'Date of Report',
            'Plumber',
            'Conversion Payment',
            'Meter Number',
            'Meter Reading',
            'GI Guard to Main Valve 1/2"',
            'GI Main Valve to Meter 1/2"',
            'GI Meter to Geyser 1/2"',
            'GI Geyser Point 1/2"',
            'Extra Kitchen Point',
            'Total GI',
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
            'Open Cut 20mm',
            'Boring 20mm',
            'Total MDPE Pipe 20mm',
            'Tee 20mm',
            'RCC Guard 20mm',
            'GF Coupler 20mm',
            'GF Saddle 32x20mm',
            'GF Saddle 63x20mm',
            'GF Saddle 63x32mm',
            'GF Saddle 125x32',
            'GF Saddle 90x20mm',
            'GF Reducer 32x20mm',
            'NEPL Claim',
            'Offline Drawing',
            'GC Done By',
            'V Lookup',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Map each row
     */
    public function map($png): array
    {
        return [
            $png->po_number ?? '',
            $png->service_order_no ?? '',
            $png->agreement_date ? $png->agreement_date->format('d-m-Y') : '',
            $png->booking_by ?? '',
            $png->start_date ? $png->start_date->format('d-m-Y') : '',
            $png->plan_type ? ucfirst($png->plan_type) : '',
            $png->customer ?? '',
            $png->application_no ?? '',
            $png->notification_numbers ?? '',
            $png->customer_name ?? '',
            $png->house_no ?? '',
            $png->street_1 ?? '',
            $png->street_2 ?? '',
            $png->street_3 ?? '',
            $png->street_4 ?? '',
            $png->customer_contact_no ?? '',
            $png->geyser_point ?? 0,
            $png->extra_kitchen ?? 0,
            $png->sla_days ?? '',
            $png->current_remarks ?? '',
            $png->witnesses_name_date ?? '',
            $png->previous_remarks ?? '',
            $png->witnesses_name_date_2 ?? '',
            $png->reported ? ucfirst($png->reported) : '',
            $png->plb_name ? ucfirst($png->plb_name) : '',
            $png->plb_date ? $png->plb_date->format('d-m-Y') : '',
            $png->pdt_date ? $png->pdt_date->format('d-m-Y') : '',
            $png->pdt_tpi ?? '',
            $png->pe_status ? ucfirst($png->pe_status) : '',
            $png->gc_date ? $png->gc_date->format('d-m-Y') : '',
            $png->gc_tpi ? ucfirst($png->gc_tpi) : '',
            $png->mmt_date ? $png->mmt_date->format('d-m-Y') : '',
            $png->mmt_tpi ?? '',
            $png->conversion_date ? $png->conversion_date->format('d-m-Y') : '',
            $png->conversion_technician ? ucfirst($png->conversion_technician) : '',
            $png->date_of_report ? $png->date_of_report->format('d-m-Y') : '',
            $png->plumber ? ucfirst($png->plumber) : '',
            $png->conversion_payment ?? '',
            $png->meter_number ?? '',
            $png->meter_reading ? number_format($png->meter_reading, 2) : '',
            $png->gi_guard_to_main_valve_half_inch ? number_format($png->gi_guard_to_main_valve_half_inch, 2) : '',
            $png->gi_main_valve_to_meter_half_inch ? number_format($png->gi_main_valve_to_meter_half_inch, 2) : '',
            $png->gi_meter_to_geyser_half_inch ? number_format($png->gi_meter_to_geyser_half_inch, 2) : '',
            $png->gi_geyser_point_half_inch ? number_format($png->gi_geyser_point_half_inch, 2) : '',
            $png->extra_kitchen_point ? number_format($png->extra_kitchen_point, 2) : '',
            $png->total_gi ? number_format($png->total_gi, 2) : '',
            $png->high_press_1_6_reg ?? 0,
            $png->low_press_2_5_reg ?? 0,
            $png->reg_qty ?? 0,
            $png->gas_tap ?? 0,
            $png->valve_half_inch ?? 0,
            $png->gi_coupling_half_inch ?? 0,
            $png->gi_elbow_half_inch ?? 0,
            $png->calmp_half_inch ?? 0,
            $png->gi_tee_half_inch ?? 0,
            $png->anaconda ?? 0,
            $png->open_cut_20mm ? number_format($png->open_cut_20mm, 2) : '',
            $png->boring_20mm ? number_format($png->boring_20mm, 2) : '',
            $png->total_mdpe_pipe_20mm ? number_format($png->total_mdpe_pipe_20mm, 2) : '',
            $png->tee_20mm ?? 0,
            $png->rcc_guard_20mm ?? 0,
            $png->gf_coupler_20mm ?? 0,
            $png->gf_saddle_32x20mm ?? 0,
            $png->gf_saddle_63x20mm ?? 0,
            $png->gf_saddle_63x32mm ?? 0,
            $png->gf_saddle_125x32 ?? 0,
            $png->gf_saddle_90x20mm ?? 0,
            $png->gf_reducer_32x20mm ?? 0,
            $png->nepl_claim ?? '',
            $png->offline_drawing ?? '',
            $png->gc_done_by ?? '',
            $png->v_lookup ?? '',
            $png->created_at ? $png->created_at->format('d-m-Y H:i:s') : '',
            $png->updated_at ? $png->updated_at->format('d-m-Y H:i:s') : '',
        ];
    }

    /**
     * Apply styles to the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as header
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FF4472C4',
                    ],
                ],
                'font' => [
                    'color' => [
                        'argb' => 'FFFFFFFF',
                    ],
                    'bold' => true,
                ],
            ],
        ];
    }
}
