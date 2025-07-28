<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\PeTracker;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;

class PeTrackerExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
   protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Query for export with filters applied.
     */
    public function query()
    {
        $query = PeTracker::query();

        // Apply same filters as index method
        if ($this->request->filled('activity')) {
            $query->byActivity($this->request->input('activity'));
        }

        if ($this->request->filled('supervisor')) {
            $query->bySupervisor($this->request->input('supervisor'));
        }

        if ($this->request->filled('mukadam_name')) {
            $query->where('mukadam_name', 'like', '%' . $this->request->input('mukadam_name') . '%');
        }

        if ($this->request->filled('start_date') || $this->request->filled('end_date')) {
            $query->byDateRange($this->request->input('start_date'), $this->request->input('end_date'));
        }

        if ($this->request->filled('dpr_no')) {
            $query->where('dpr_no', 'like', '%' . $this->request->input('dpr_no') . '%');
        }

        return $query->orderBy('date', 'desc');
    }

    /**
     * Define Excel headings.
     */
    public function headings(): array
    {
        return [
            'Date',
            'DPR No',
            'Site Names',
            'Activity',
            'Mukadam Name',
            'Supervisor',
            'TPI Name',
            'RA Bill No',
            'Total Laying Length (m)',
            '32 MM Laying Open Cut',
            '63 MM Laying Open Cut',
            '90 MM Laying Open Cut',
            '125 MM Laying Open Cut',
            '32 MM Manual Boring',
            '63 MM Manual Boring',
            '90 MM Manual Boring',
            '125 MM Manual Boring',
            '32 MM Manual Boring Casing 50MM',
            '63 MM Manual Boring Casing 90MM',
            '90 MM Manual Boring Casing 125MM',
            '125 MM Manual Boring Casing 160MM',
            'Breaking Hard Rock Completion',
            'Excavation Beyond 2M Depth',
            'Breaking Hard Surface Cutter/Breaker',
            'RCC Cutting/Breaking 150',
            'PCC Cutting/Breaking 150',
            'Restoration Asphalted Surface',
            'Restoration Cement Concrete',
            'Restoration Tiles/PB/Kerstone/Brick',
            'Restoration Reinforced Cement Concrete',
            'Const/Supply/Installation VC',
            'Installation SR 5 Regulator',
            'Installation of 5 SRM',
            'Installation of B-10 SRM',
            'Installation of B-25 SRM',
            'Installation of B-50 SRM',
            'Installation of B-100 SRM',
            'Supply/Install Route Markers Type-B',
            'Supply/Install Markers Type-B',
            'Hard Barricading for MP Pipeline',
            'Barricating for LP Pipeline',
            'Liasoning Statutory/Conc Ern Authorities',
            'PCC 1:2:4 By Mass',
            'PCC 1:4:8 By Mass',
            'RCC of Grade M-20',
            'RCC of Grade M-25',
            'Brick Work M-7.5 Cement Mortar 1:3:4',
            'RCC of Grade M-25 for Drain Cross Over',
            'PE Service Lines of Cut 20MM',
            'Installation of 3/4" NB',
            'Individual House 1/2" NB GI Upto MCV',
            'Individual House GI/CU Rom MCV to AV',
            'Individual House Conversio N',
            'Apt/High Rise Flats Con Rom MCV to AV',
            'Apt/High Rise Con Rom MCV to AV',
            'Apt/High Rise Flats Con Conversio N',
            'Riser or Header Inst 1/2"',
            'Riser or Header Inst 1"',
            'Riser or Header Inst 1-1/4" 1/2"',
            'Welded Riser 1/2" NB',
            'Welded Riser 1" NB',
            'Welded Riser 1-1/2" NB',
            'Welded Riser 2" NB',
            'Additional Point Customer Request',
            'Installation Test,Com Mission Upto G 10',
            'Installation Test,Com Mission Above G 10',
            'Industrial Hookup Upto 2" Inlet',
            'Industrial Hookup 4" Inlet',
            'Industrial Hookup with DRS',
            'HAL HUME UN',
            '20mm EC',
            '32mm EC',
            '63mm EC',
            '90mm EC',
            '125mm EC',
            '32mm Elbow',
            '63mm Elbow',
            'Flushing/Testing Done',
            'Commissioning',
            'Created At',
            'Updated At'
        ];
    }

    /**
     * Map each row to Excel columns.
     */
    public function map($peTracker): array
    {
        return [
            $peTracker->date->format('d-m-Y'),
            $peTracker->dpr_no,
            $peTracker->sites_names,
            $peTracker->activity,
            $peTracker->mukadam_name,
            $peTracker->supervisor,
            $peTracker->tpi_name,
            $peTracker->ra_bill_no,
            $peTracker->total_laying_length ? number_format($peTracker->total_laying_length, 2) : '0.00',
            
            // Measurements
            $this->formatNumeric($peTracker->getMeasurement('32_mm_laying_open_cut')),
            $this->formatNumeric($peTracker->getMeasurement('63_mm_laying_open_cut')),
            $this->formatNumeric($peTracker->getMeasurement('90_mm_laying_open_cut')),
            $this->formatNumeric($peTracker->getMeasurement('125_mm_laying_open_cut')),
            $this->formatNumeric($peTracker->getMeasurement('32_mm_manual_boring')),
            $this->formatNumeric($peTracker->getMeasurement('63_mm_manual_boring')),
            $this->formatNumeric($peTracker->getMeasurement('90_mm_manual_boring')),
            $this->formatNumeric($peTracker->getMeasurement('125_mm_manual_boring')),
            $this->formatNumeric($peTracker->getMeasurement('32_mm_manual_boring_casing_50mm')),
            $this->formatNumeric($peTracker->getMeasurement('63_mm_manual_boring_casing_90mm')),
            $this->formatNumeric($peTracker->getMeasurement('90_mm_manual_boring_casing_125mm')),
            $this->formatNumeric($peTracker->getMeasurement('125_mm_manual_boring_casing_160mm')),
            $this->formatNumeric($peTracker->getMeasurement('breaking_hard_rock_completion')),
            $this->formatNumeric($peTracker->getMeasurement('excavation_beyond_2m_depth')),
            $this->formatNumeric($peTracker->getMeasurement('breaking_hard_surface_cutter_brea_ker')),
            $this->formatNumeric($peTracker->getMeasurement('rcc_cutting_breaking_150')),
            $this->formatNumeric($peTracker->getMeasurement('pcc_cutting_breaking_150')),
            
            // Installation Data
            $this->formatNumeric($peTracker->getInstallationData('restoration_asphalted_surface')),
            $this->formatNumeric($peTracker->getInstallationData('restoration_cement_concrete')),
            $this->formatNumeric($peTracker->getInstallationData('restoration_tiles_pb_kerstone_brick')),
            $this->formatNumeric($peTracker->getInstallationData('restoration_reinforced_cement_concrete')),
            $this->formatNumeric($peTracker->getInstallationData('const_supply_installation_vc')),
            $this->formatNumeric($peTracker->getInstallationData('installation_sr_5_regulator')),
            $this->formatNumeric($peTracker->getInstallationData('installation_of_5_srm')),
            $this->formatNumeric($peTracker->getInstallationData('installation_of_b_10_srm')),
            $this->formatNumeric($peTracker->getInstallationData('installation_of_b_25_srm')),
            $this->formatNumeric($peTracker->getInstallationData('installation_of_b_50_srm')),
            $this->formatNumeric($peTracker->getInstallationData('installation_of_b_100_srm')),
            
            // Pipe Fittings
            $this->formatNumeric($peTracker->getPipeFitting('supply_install_route_markers_type_b')),
            $this->formatNumeric($peTracker->getPipeFitting('supply_install_markers_type_b')),
            $this->formatNumeric($peTracker->getPipeFitting('hard_barricading_for_mp_pipeline')),
            $this->formatNumeric($peTracker->getPipeFitting('barricating_for_lp_pipeline')),
            $this->formatNumeric($peTracker->getPipeFitting('liasoning_statutory_conc_ern_authorities')),
            $this->formatNumeric($peTracker->getPipeFitting('pcc_124_by_mass')),
            $this->formatNumeric($peTracker->getPipeFitting('pcc_148_by_mass')),
            $this->formatNumeric($peTracker->getPipeFitting('rcc_of_grade_m20')),
            $this->formatNumeric($peTracker->getPipeFitting('rcc_of_grade_m25')),
            $this->formatNumeric($peTracker->getPipeFitting('brick_work_m75_cement_mortar_134')),
            $this->formatNumeric($peTracker->getPipeFitting('rcc_of_grade_m25_for_drain_cross_over')),
            $this->formatNumeric($peTracker->getPipeFitting('pe_service_lines_of_cut_20mm')),
            $this->formatNumeric($peTracker->getPipeFitting('installation_of_34_nb')),
            $this->formatNumeric($peTracker->getPipeFitting('individual_house_12_nb_gi_upto_mcv')),
            $this->formatNumeric($peTracker->getPipeFitting('individual_house_gi_cu_rom_mcv_to_av')),
            $this->formatNumeric($peTracker->getPipeFitting('individual_house_conversio_n')),
            $this->formatNumeric($peTracker->getPipeFitting('apt_high_rise_flats_con_rom_mcv_to_av')),
            $this->formatNumeric($peTracker->getPipeFitting('apt_high_rise_con_rom_mcv_to_av')),
            $this->formatNumeric($peTracker->getPipeFitting('apt_high_rise_flats_con_conversio_n')),
            $this->formatNumeric($peTracker->getPipeFitting('riser_or_header_inst_12')),
            $this->formatNumeric($peTracker->getPipeFitting('riser_or_header_inst_1')),
            $this->formatNumeric($peTracker->getPipeFitting('riser_or_header_inst_114_12')),
            $this->formatNumeric($peTracker->getPipeFitting('welded_riser_12_nb')),
            $this->formatNumeric($peTracker->getPipeFitting('welded_riser_1_nb')),
            $this->formatNumeric($peTracker->getPipeFitting('welded_riser_112_nb')),
            $this->formatNumeric($peTracker->getPipeFitting('welded_riser_2_nb')),
            
            // Testing Data
            $this->formatNumeric($peTracker->getTestingData('additional_point_customer_request')),
            $this->formatNumeric($peTracker->getTestingData('installation_test_com_mission_upto_g10')),
            $this->formatNumeric($peTracker->getTestingData('installation_test_com_mission_above_g10')),
            $this->formatNumeric($peTracker->getTestingData('industrial_hookup_upto_2_inlet')),
            $this->formatNumeric($peTracker->getTestingData('industrial_hookup_4_inlet')),
            $this->formatNumeric($peTracker->getTestingData('industrial_hookup_with_drs')),
            $this->formatNumeric($peTracker->getTestingData('hal_hume_un')),
            $this->formatNumeric($peTracker->getTestingData('20mm_ec')),
            $this->formatNumeric($peTracker->getTestingData('32mm_ec')),
            $this->formatNumeric($peTracker->getTestingData('63mm_ec')),
            $this->formatNumeric($peTracker->getTestingData('90mm_ec')),
            $this->formatNumeric($peTracker->getTestingData('125mm_ec')),
            $this->formatNumeric($peTracker->getTestingData('32mm_elbow')),
            $this->formatNumeric($peTracker->getTestingData('63mm_elbow')),
            $peTracker->getTestingData('flushing_testing_done') ?: '',
            $peTracker->getTestingData('commissioning') ?: '',
            
            $peTracker->created_at->format('d-m-Y H:i'),
            $peTracker->updated_at->format('d-m-Y H:i'),
        ];
    }

    /**
     * Apply styles to the worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold
            1 => ['font' => ['bold' => true, 'size' => 12]],
            
            // Set background color for header
            'A1:BX1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE2E2E2']
                ]
            ],
        ];
    }

    /**
     * Format numeric values for export.
     */
    private function formatNumeric($value)
    {
        if ($value === null || $value === '') {
            return '';
        }
        
        if (is_numeric($value)) {
            return number_format($value, 2);
        }
        
        return $value;
    }
}
