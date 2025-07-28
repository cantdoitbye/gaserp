<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeTracker;
use App\Http\Requests\PeTrackerRequest;
use App\Exports\PeTrackerExport;
use App\Imports\PeTrackerImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PeTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PeTracker::query();

        // Apply filters
        if ($request->filled('activity')) {
            $query->byActivity($request->input('activity'));
        }

        if ($request->filled('supervisor')) {
            $query->bySupervisor($request->input('supervisor'));
        }

        if ($request->filled('mukadam_name')) {
            $query->where('mukadam_name', 'like', '%' . $request->input('mukadam_name') . '%');
        }

        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query->byDateRange($request->input('start_date'), $request->input('end_date'));
        }

        if ($request->filled('dpr_no')) {
            $query->where('dpr_no', 'like', '%' . $request->input('dpr_no') . '%');
        }

        // Sorting
        $sortField = $request->input('sort', 'date');
        $sortDirection = $request->input('direction', 'desc');
        
        $allowedSortFields = ['date', 'dpr_no', 'activity', 'supervisor', 'total_laying_length'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'date';
        }
        
        $peTrackers = $query->orderBy($sortField, $sortDirection)->paginate(15);
        
        // Get filter options
        $activities = PeTracker::getActivityOptions();
        $supervisors = PeTracker::getUniqueSupervisors();
        $mukadams = PeTracker::getUniqueMukadams();

        return view('panel.pe-tracker.index', compact(
            'peTrackers', 
            'activities', 
            'supervisors', 
            'mukadams',
            'sortField',
            'sortDirection'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activities = PeTracker::getActivityOptions();
        $supervisors = PeTracker::getUniqueSupervisors();
        $mukadams = PeTracker::getUniqueMukadams();
        
        return view('panel.pe-tracker.create', compact('activities', 'supervisors', 'mukadams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PeTrackerRequest $request)
    {
        $data = $request->validated();
        
        // Process and organize data into JSON fields
        $measurements = $this->organizeMeasurements($request);
        $installationData = $this->organizeInstallationData($request);
        $pipeFittings = $this->organizePipeFittings($request);
        $testingData = $this->organizeTestingData($request);
        
        $data['measurements'] = $measurements;
        $data['installation_data'] = $installationData;
        $data['pipe_fittings'] = $pipeFittings;
        $data['testing_data'] = $testingData;
        
        $peTracker = PeTracker::create($data);
        
        // Calculate and update total laying length
        $peTracker->total_laying_length = $peTracker->calculateTotalLaying();
        $peTracker->save();

        return redirect()->route('pe-tracker.index')
            ->with('success', 'PE Tracker record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PeTracker $peTracker)
    {
        return view('panel.pe-tracker.show', compact('peTracker'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeTracker $peTracker)
    {
        $activities = PeTracker::getActivityOptions();
        $supervisors = PeTracker::getUniqueSupervisors();
        $mukadams = PeTracker::getUniqueMukadams();
        
        return view('panel.pe-tracker.edit', compact('peTracker', 'activities', 'supervisors', 'mukadams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PeTrackerRequest $request, PeTracker $peTracker)
    {
        $data = $request->validated();
        
        // Process and organize data into JSON fields
        $measurements = $this->organizeMeasurements($request);
        $installationData = $this->organizeInstallationData($request);
        $pipeFittings = $this->organizePipeFittings($request);
        $testingData = $this->organizeTestingData($request);
        
        $data['measurements'] = $measurements;
        $data['installation_data'] = $installationData;
        $data['pipe_fittings'] = $pipeFittings;
        $data['testing_data'] = $testingData;
        
        $peTracker->update($data);
        
        // Recalculate total laying length
        $peTracker->total_laying_length = $peTracker->calculateTotalLaying();
        $peTracker->save();

        return redirect()->route('pe-tracker.index')
            ->with('success', 'PE Tracker record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PeTracker $peTracker)
    {
        $peTracker->delete();

        return redirect()->route('pe-tracker.index')
            ->with('success', 'PE Tracker record deleted successfully.');
    }

    /**
     * Show import form
     */
    public function showImportForm()
    {
        return view('panel.pe-tracker.import');
    }

    /**
     * Import PE Tracker data from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new PeTrackerImport, $request->file('excel_file'));

        return redirect()->route('pe-tracker.index')
            ->with('success', 'PE Tracker data imported successfully.');
    }

    /**
     * Export PE Tracker data to Excel
     */
    public function export(Request $request)
    {
        return Excel::download(new PeTrackerExport($request), 'pe-tracker-data.xlsx');
    }

    /**
     * Organize measurements data from request
     */
    private function organizeMeasurements(Request $request)
    {
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
        
        $measurements = [];
        foreach ($measurementFields as $field) {
            if ($request->filled($field)) {
                $measurements[$field] = $request->input($field);
            }
        }
        
        return $measurements;
    }

    /**
     * Organize installation data from request
     */
    private function organizeInstallationData(Request $request)
    {
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
        
        $installation = [];
        foreach ($installationFields as $field) {
            if ($request->filled($field)) {
                $installation[$field] = $request->input($field);
            }
        }
        
        return $installation;
    }

    /**
     * Organize pipe fittings data from request
     */
    private function organizePipeFittings(Request $request)
    {
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
            'pe_service_lines_of_cut_20mm',
            'installation_of_34_nb',
            'individual_house_12_nb_gi_upto_mcv',
            'individual_house_gi_cu_rom_mcv_to_av',
            'individual_house_conversio_n',
            'apt_high_rise_flats_con_rom_mcv_to_av',
            'apt_high_rise_con_rom_mcv_to_av',
            'apt_high_rise_flats_con_conversio_n',
            'riser_or_header_inst_12',
            'riser_or_header_inst_1',
            'riser_or_header_inst_114_12',
            'welded_riser_12_nb',
            'welded_riser_1_nb',
            'welded_riser_112_nb',
            'welded_riser_2_nb'
        ];
        
        $pipeFittings = [];
        foreach ($pipeFittingFields as $field) {
            if ($request->filled($field)) {
                $pipeFittings[$field] = $request->input($field);
            }
        }
        
        return $pipeFittings;
    }

    /**
     * Organize testing data from request
     */
    private function organizeTestingData(Request $request)
    {
        $testingFields = [
            'additional_point_customer_request',
            'installation_test_com_mission_upto_g10',
            'installation_test_com_mission_above_g10',
            'industrial_hookup_upto_2_inlet',
            'industrial_hookup_4_inlet',
            'industrial_hookup_with_drs',
            'hal_hume_un',
            '20mm_ec',
            '32mm_ec',
            '63mm_ec',
            '90mm_ec',
            '125mm_ec',
            '32mm_elbow',
            '63mm_elbow',
            'flushing_testing_done',
            'commissioning'
        ];
        
        $testing = [];
        foreach ($testingFields as $field) {
            if ($request->filled($field)) {
                $testing[$field] = $request->input($field);
            }
        }
        
        return $testing;
    }
}
