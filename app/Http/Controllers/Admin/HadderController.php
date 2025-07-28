<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hadder;
use App\Models\Ladder;
use App\Models\PngMeasurementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class HadderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Hadder::with(['measurementType']);

        // Generate status counts for the report (before applying filters)
        $statusCounts = [
            'total' => Hadder::count(),
            'workable' => Hadder::where('connections_status', 'workable')->count(),
            'not_workable' => Hadder::where('connections_status', 'not_workable')->count(),
            'plb_done' => Hadder::where('connections_status', 'plb_done')->count(),
            'pdt_pending' => Hadder::where('connections_status', 'pdt_pending')->count(),
            'gc_pending' => Hadder::where('connections_status', 'gc_pending')->count(),
            'mmt_pending' => Hadder::where('connections_status', 'mmt_pending')->count(),
            'conv_pending' => Hadder::where('connections_status', 'conv_pending')->count(),
            'comm' => Hadder::where('connections_status', 'comm')->count(),
            'report_pending' => Hadder::where('connections_status', 'report_pending')->count(),
            'bill_pending' => Hadder::where('connections_status', 'bill_pending')->count(),
            'bill_received' => Hadder::where('connections_status', 'bill_received')->count(),
        ];

        // Apply filters similar to PNG controller
        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'LIKE', '%' . $request->customer_name . '%');
        }

        if ($request->filled('service_order_no')) {
            $query->where('service_order_no', 'LIKE', '%' . $request->service_order_no . '%');
        }

        if ($request->filled('customer_no')) {
            $query->where('customer_no', 'LIKE', '%' . $request->customer_no . '%');
        }

        if ($request->filled('application_no')) {
            $query->where('application_no', 'LIKE', '%' . $request->application_no . '%');
        }

        if ($request->filled('contact_no')) {
            $query->where('contact_no', 'LIKE', '%' . $request->contact_no . '%');
        }

        if ($request->filled('address')) {
            $query->where('address', 'LIKE', '%' . $request->address . '%');
        }

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        if ($request->filled('scheme')) {
            $query->where('scheme', $request->scheme);
        }

        if ($request->filled('connections_status')) {
            $query->where('connections_status', $request->connections_status);
        }

        if ($request->filled('conversion_status')) {
            $query->where('conversion_status', $request->conversion_status);
        }

        if ($request->filled('png_measurement_type_id')) {
            $query->where('png_measurement_type_id', $request->png_measurement_type_id);
        }

        // Date range filters
        if ($request->filled('agreement_date_from')) {
            $query->whereDate('agreement_date', '>=', $request->agreement_date_from);
        }

        if ($request->filled('agreement_date_to')) {
            $query->whereDate('agreement_date', '<=', $request->agreement_date_to);
        }

        // SLA Days filter
        if ($request->filled('sla_days')) {
            $slaDays = $request->sla_days;
            $query->whereNotNull('agreement_date')
                  ->whereRaw('DATEDIFF(NOW(), agreement_date) = ?', [$slaDays]);
        }

        // Sorting
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        
        $fieldMapping = [
            'name' => 'customer_name',
            'plumber_name' => 'plb_name',
            'plumbing_date' => 'plb_date',
        ];
        
        $actualSortField = $fieldMapping[$sortField] ?? $sortField;
        
        $allowedSortFields = [
            'created_at', 'updated_at', 'agreement_date', 'customer_name', 'area', 
            'connections_status', 'conversion_status', 'plb_name', 'plb_date',
            'conversion_date', 'service_order_no', 'customer_no'
        ];
        
        if (!in_array($actualSortField, $allowedSortFields)) {
            $actualSortField = 'created_at';
            $sortDirection = 'desc';
        }

        $query->orderBy($actualSortField, $sortDirection);

        // Pagination
        $ladders = $query->paginate(15)->withQueryString();

        // Get measurement types for filter dropdown
        $measurementTypes = PngMeasurementType::where('png_type', 'ladder')->orderBy('name')->get(['id', 'name']);

        return view('panel.ladder.index', compact('ladders', 'measurementTypes', 'statusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $measurementTypes = PngMeasurementType::where('png_type', 'ladder')->where('is_active', true)->get();
        return view('panel.ladder.create', compact('measurementTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            // Handle file uploads - convert arrays to JSON strings
            if ($request->hasFile('scan_copy')) {
                $data['scan_copy_path'] = $request->file('scan_copy')->store('ladder_scan_copies', 'public');
            }

            if ($request->hasFile('autocad_drawing')) {
                $data['autocad_drawing_path'] = $request->file('autocad_drawing')->store('ladder_autocad_drawings', 'public');
            }

            if ($request->hasFile('certificate')) {
                $data['certificate_path'] = $request->file('certificate')->store('ladder_certificates', 'public');
            }

            // Handle Job Cards - store as JSON
            if ($request->hasFile('job_cards')) {
                $jobCardsPaths = [];
                foreach ($request->file('job_cards') as $file) {
                    $path = $file->store('ladder_job_cards', 'public');
                    $jobCardsPaths[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                $data['job_cards_paths'] = json_encode($jobCardsPaths);
            }

            // Handle AutoCad DWG files - store as JSON
            if ($request->hasFile('autocad_dwg')) {
                $autocadPaths = [];
                foreach ($request->file('autocad_dwg') as $file) {
                    $path = $file->store('ladder_autocad_dwg', 'public');
                    $autocadPaths[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                $data['autocad_dwg_paths'] = json_encode($autocadPaths);
            }

            // Handle Site Visit Reports - store as JSON
            if ($request->hasFile('site_visit_reports')) {
                $reportsPaths = [];
                foreach ($request->file('site_visit_reports') as $file) {
                    $path = $file->store('ladder_site_visit_reports', 'public');
                    $reportsPaths[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                $data['site_visit_reports_paths'] = json_encode($reportsPaths);
            }

            // Handle Other Documents - store as JSON
            if ($request->hasFile('other_documents')) {
                $otherDocs = [];
                foreach ($request->file('other_documents') as $file) {
                    $path = $file->store('ladder_other_documents', 'public');
                    $otherDocs[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                $data['other_documents_paths'] = json_encode($otherDocs);
            }

            // Handle additional documents - store as JSON
            if ($request->hasFile('additional_documents')) {
                $additionalDocs = [];
                foreach ($request->file('additional_documents') as $file) {
                    $path = $file->store('ladder_additional_docs', 'public');
                    $additionalDocs[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                $data['additional_documents'] = json_encode($additionalDocs);
            }

            // Handle measurements array - store as measurements_data
            if (isset($data['measurements']) && is_array($data['measurements'])) {
                $data['measurements_data'] = $data['measurements'];
                unset($data['measurements']);
            }

            // Map form field names to model field names if needed
            if (isset($data['plumber_name'])) {
                $data['plb_name'] = $data['plumber_name'];
            }
            
            if (isset($data['plumbing_date'])) {
                $data['plb_date'] = $data['plumbing_date'];
            }

            $ladder = Hadder::create($data);

            return redirect()->route('ladder.index')
                ->with('success', 'Ladder job created successfully.');

        } catch (\Exception $e) {
            \Log::error('Ladder Creation Error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', "Error occurred: {$e->getMessage()}");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Hadder $ladder)
    {
        $ladder->load('measurementType');
        return view('panel.ladder.show', compact('ladder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hadder $ladder)
    {
        $ladder->load('measurementType');
        $measurementTypes = PngMeasurementType::where('png_type', 'ladder')->where('is_active', true)->get();
        return view('panel.ladder.edit', compact('ladder', 'measurementTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hadder $ladder)
    {
        try {
            $data = $request->all();

            // Handle single file uploads (replace existing)
            if ($request->hasFile('scan_copy')) {
                if ($ladder->scan_copy_path && Storage::disk('public')->exists($ladder->scan_copy_path)) {
                    Storage::disk('public')->delete($ladder->scan_copy_path);
                }
                $data['scan_copy_path'] = $request->file('scan_copy')->store('ladder_scan_copies', 'public');
            }

            if ($request->hasFile('autocad_drawing')) {
                if ($ladder->autocad_drawing_path && Storage::disk('public')->exists($ladder->autocad_drawing_path)) {
                    Storage::disk('public')->delete($ladder->autocad_drawing_path);
                }
                $data['autocad_drawing_path'] = $request->file('autocad_drawing')->store('ladder_autocad_drawings', 'public');
            }

            if ($request->hasFile('certificate')) {
                if ($ladder->certificate_path && Storage::disk('public')->exists($ladder->certificate_path)) {
                    Storage::disk('public')->delete($ladder->certificate_path);
                }
                $data['certificate_path'] = $request->file('certificate')->store('ladder_certificates', 'public');
            }

            // Handle multiple files - append to existing
            if ($request->hasFile('job_cards')) {
                $existingJobCards = $ladder->job_cards_paths ?? [];
                $newJobCards = [];
                
                foreach ($request->file('job_cards') as $file) {
                    $path = $file->store('ladder_job_cards', 'public');
                    $newJobCards[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                
                $data['job_cards_paths'] = json_encode(array_merge($existingJobCards, $newJobCards));
            }

            if ($request->hasFile('autocad_dwg')) {
                $existingAutocadFiles = $ladder->autocad_dwg_paths ?? [];
                $newAutocadFiles = [];
                
                foreach ($request->file('autocad_dwg') as $file) {
                    $path = $file->store('ladder_autocad_dwg', 'public');
                    $newAutocadFiles[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                
                $data['autocad_dwg_paths'] = json_encode(array_merge($existingAutocadFiles, $newAutocadFiles));
            }

            if ($request->hasFile('site_visit_reports')) {
                $existingReports = $ladder->site_visit_reports_paths ?? [];
                $newReports = [];
                
                foreach ($request->file('site_visit_reports') as $file) {
                    $path = $file->store('ladder_site_visit_reports', 'public');
                    $newReports[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                
                $data['site_visit_reports_paths'] = json_encode(array_merge($existingReports, $newReports));
            }

            if ($request->hasFile('other_documents')) {
                $existingOtherDocs = $ladder->other_documents_paths ?? [];
                $newOtherDocs = [];
                
                foreach ($request->file('other_documents') as $file) {
                    $path = $file->store('ladder_other_documents', 'public');
                    $newOtherDocs[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                
                $data['other_documents_paths'] = json_encode(array_merge($existingOtherDocs, $newOtherDocs));
            }

            if ($request->hasFile('additional_documents')) {
                $existingAdditionalDocs = $ladder->additional_documents ?? [];
                $newAdditionalDocs = [];
                
                foreach ($request->file('additional_documents') as $file) {
                    $path = $file->store('ladder_additional_docs', 'public');
                    $newAdditionalDocs[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                
                $data['additional_documents'] = json_encode(array_merge($existingAdditionalDocs, $newAdditionalDocs));
            }

            // Handle measurements array
            if (isset($data['measurements']) && is_array($data['measurements'])) {
                $data['measurements_data'] = $data['measurements'];
                unset($data['measurements']);
            }

            // Map form field names to model field names
            if (isset($data['plumber_name'])) {
                $data['plb_name'] = $data['plumber_name'];
            }
            
            if (isset($data['plumbing_date'])) {
                $data['plb_date'] = $data['plumbing_date'];
            }

            $ladder->update($data);

            return redirect()->route('ladder.show', $ladder->id)
                ->with('success', 'Ladder job updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Ladder Update Error: ' . $e->getMessage(), [
                'ladder_id' => $ladder->id,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', "Error occurred: {$e->getMessage()}");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hadder $ladder)
    {
        // Delete associated files
        if ($ladder->scan_copy_path) {
            Storage::disk('public')->delete($ladder->scan_copy_path);
        }

        if ($ladder->autocad_drawing_path) {
            Storage::disk('public')->delete($ladder->autocad_drawing_path);
        }

        if ($ladder->certificate_path) {
            Storage::disk('public')->delete($ladder->certificate_path);
        }

        // Delete multiple files
        if ($ladder->job_cards_paths) {
            foreach ($ladder->job_cards_paths as $jobCard) {
                if (isset($jobCard['path'])) {
                    Storage::disk('public')->delete($jobCard['path']);
                }
            }
        }

        if ($ladder->autocad_dwg_paths) {
            foreach ($ladder->autocad_dwg_paths as $dwgFile) {
                if (isset($dwgFile['path'])) {
                    Storage::disk('public')->delete($dwgFile['path']);
                }
            }
        }

        if ($ladder->site_visit_reports_paths) {
            foreach ($ladder->site_visit_reports_paths as $report) {
                if (isset($report['path'])) {
                    Storage::disk('public')->delete($report['path']);
                }
            }
        }

        if ($ladder->other_documents_paths) {
            foreach ($ladder->other_documents_paths as $doc) {
                if (isset($doc['path'])) {
                    Storage::disk('public')->delete($doc['path']);
                }
            }
        }

        if ($ladder->additional_documents) {
            foreach ($ladder->additional_documents as $doc) {
                if (isset($doc['path'])) {
                    Storage::disk('public')->delete($doc['path']);
                }
            }
        }

        $ladder->delete();

        return redirect()->route('ladder.index')
            ->with('success', 'Ladder job deleted successfully.');
    }

    /**
     * Show import form
     */
    public function showImportForm()
    {
        return view('panel.ladder.import');
    }

    /**
     * Export Ladder data to Excel
     */
    public function export(Request $request)
    {
        // You can create a LadderExport class similar to PngExport
        return response()->json(['message' => 'Export functionality to be implemented']);
    }

    /**
     * Get summary statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_jobs' => Hadder::count(),
            'workable_jobs' => Hadder::where('connections_status', 'workable')->count(),
            'completed_jobs' => Hadder::where('conversion_status', 'conv_done')->count(),
            'pending_jobs' => Hadder::whereIn('connections_status', ['pdt_pending', 'gc_pending', 'mmt_pending'])->count(),
            'this_month_jobs' => Hadder::whereMonth('created_at', now()->month)->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get measurement types by Ladder type (AJAX)
     */
    public function getMeasurementTypesByLadderType(Request $request)
    {
        $ladderType = $request->input('ladder_type');
        
        $measurementTypes = PngMeasurementType::where('is_active', true)
            ->where('png_type', 'ladder')
            ->get(['id', 'name', 'description']);

        return response()->json($measurementTypes);
    }

    /**
     * Get measurement fields for a type (AJAX)
     */
    public function getMeasurementFields(Request $request)
    {
        $measurementTypeId = $request->input('measurement_type_id');
        $measurementType = PngMeasurementType::find($measurementTypeId);
        
        if (!$measurementType) {
            return response()->json(['error' => 'Measurement type not found'], 404);
        }

        return response()->json([
            'measurement_type' => $measurementType,
            'fields' => $measurementType->measurement_fields
        ]);
    }

}
