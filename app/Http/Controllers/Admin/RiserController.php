<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Riser;
use App\Models\PngMeasurementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class RiserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Riser::with(['measurementType']);

        // Generate status counts for the report (before applying filters)
        $statusCounts = [
            'total' => Riser::count(),
            'workable' => Riser::where('connections_status', 'workable')->count(),
            'not_workable' => Riser::where('connections_status', 'not_workable')->count(),
            'plb_done' => Riser::where('connections_status', 'plb_done')->count(),
            'pdt_pending' => Riser::where('connections_status', 'pdt_pending')->count(),
            'gc_pending' => Riser::where('connections_status', 'gc_pending')->count(),
            'mmt_pending' => Riser::where('connections_status', 'mmt_pending')->count(),
            'conv_pending' => Riser::where('connections_status', 'conv_pending')->count(),
            'comm' => Riser::where('connections_status', 'comm')->count(),
            'report_pending' => Riser::where('connections_status', 'report_pending')->count(),
            'bill_pending' => Riser::where('connections_status', 'bill_pending')->count(),
            'bill_received' => Riser::where('connections_status', 'bill_received')->count(),
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
        $risers = $query->paginate(15)->withQueryString();

        // Get measurement types for filter dropdown
        $measurementTypes = PngMeasurementType::whereIn('png_type', ['riser', 'approach'])->orderBy('name')->get(['id', 'name']);

        return view('panel.riser.index', compact('risers', 'measurementTypes', 'statusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $measurementTypes = PngMeasurementType::whereIn('png_type', ['riser', 'approach'])->where('is_active', true)->get();
        return view('panel.riser.create', compact('measurementTypes'));
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
                $data['scan_copy_path'] = $request->file('scan_copy')->store('riser_scan_copies', 'public');
            }

            if ($request->hasFile('autocad_drawing')) {
                $data['autocad_drawing_path'] = $request->file('autocad_drawing')->store('riser_autocad_drawings', 'public');
            }

            if ($request->hasFile('certificate')) {
                $data['certificate_path'] = $request->file('certificate')->store('riser_certificates', 'public');
            }

            // Handle Job Cards - store as JSON
            if ($request->hasFile('job_cards')) {
                $jobCardsPaths = [];
                foreach ($request->file('job_cards') as $file) {
                    $path = $file->store('riser_job_cards', 'public');
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
                    $path = $file->store('riser_autocad_dwg', 'public');
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
                    $path = $file->store('riser_site_visit_reports', 'public');
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
                    $path = $file->store('riser_other_documents', 'public');
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
                    $path = $file->store('riser_additional_docs', 'public');
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

            $riser = Riser::create($data);

            return redirect()->route('riser.index')
                ->with('success', 'Riser job created successfully.');

        } catch (\Exception $e) {
            \Log::error('Riser Creation Error: ' . $e->getMessage(), [
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
    public function show(Riser $riser)
    {
        $riser->load('measurementType');
        return view('panel.riser.show', compact('riser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Riser $riser)
    {
        $riser->load('measurementType');
        $measurementTypes = PngMeasurementType::whereIn('png_type', ['riser', 'approach'])->where('is_active', true)->get();
        return view('panel.riser.edit', compact('riser', 'measurementTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Riser $riser)
    {
        try {
            $data = $request->all();

            // Handle single file uploads (replace existing)
            if ($request->hasFile('scan_copy')) {
                if ($riser->scan_copy_path && Storage::disk('public')->exists($riser->scan_copy_path)) {
                    Storage::disk('public')->delete($riser->scan_copy_path);
                }
                $data['scan_copy_path'] = $request->file('scan_copy')->store('riser_scan_copies', 'public');
            }

            if ($request->hasFile('autocad_drawing')) {
                if ($riser->autocad_drawing_path && Storage::disk('public')->exists($riser->autocad_drawing_path)) {
                    Storage::disk('public')->delete($riser->autocad_drawing_path);
                }
                $data['autocad_drawing_path'] = $request->file('autocad_drawing')->store('riser_autocad_drawings', 'public');
            }

            if ($request->hasFile('certificate')) {
                if ($riser->certificate_path && Storage::disk('public')->exists($riser->certificate_path)) {
                    Storage::disk('public')->delete($riser->certificate_path);
                }
                $data['certificate_path'] = $request->file('certificate')->store('riser_certificates', 'public');
            }

            // Handle multiple files - append to existing
            if ($request->hasFile('job_cards')) {
                $existingJobCards = $riser->job_cards_paths ?? [];
                $newJobCards = [];
                
                foreach ($request->file('job_cards') as $file) {
                    $path = $file->store('riser_job_cards', 'public');
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
                $existingAutocadFiles = $riser->autocad_dwg_paths ?? [];
                $newAutocadFiles = [];
                
                foreach ($request->file('autocad_dwg') as $file) {
                    $path = $file->store('riser_autocad_dwg', 'public');
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
                $existingReports = $riser->site_visit_reports_paths ?? [];
                $newReports = [];
                
                foreach ($request->file('site_visit_reports') as $file) {
                    $path = $file->store('riser_site_visit_reports', 'public');
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
                $existingOtherDocs = $riser->other_documents_paths ?? [];
                $newOtherDocs = [];
                
                foreach ($request->file('other_documents') as $file) {
                    $path = $file->store('riser_other_documents', 'public');
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
                $existingAdditionalDocs = $riser->additional_documents ?? [];
                $newAdditionalDocs = [];
                
                foreach ($request->file('additional_documents') as $file) {
                    $path = $file->store('riser_additional_docs', 'public');
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

            $riser->update($data);

            return redirect()->route('riser.show', $riser->id)
                ->with('success', 'Riser job updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Riser Update Error: ' . $e->getMessage(), [
                'riser_id' => $riser->id,
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
    public function destroy(Riser $riser)
    {
        // Delete associated files
        if ($riser->scan_copy_path) {
            Storage::disk('public')->delete($riser->scan_copy_path);
        }

        if ($riser->autocad_drawing_path) {
            Storage::disk('public')->delete($riser->autocad_drawing_path);
        }

        if ($riser->certificate_path) {
            Storage::disk('public')->delete($riser->certificate_path);
        }

        // Delete multiple files
        if ($riser->job_cards_paths) {
            foreach ($riser->job_cards_paths as $jobCard) {
                if (isset($jobCard['path'])) {
                    Storage::disk('public')->delete($jobCard['path']);
                }
            }
        }

        if ($riser->autocad_dwg_paths) {
            foreach ($riser->autocad_dwg_paths as $dwgFile) {
                if (isset($dwgFile['path'])) {
                    Storage::disk('public')->delete($dwgFile['path']);
                }
            }
        }

        if ($riser->site_visit_reports_paths) {
            foreach ($riser->site_visit_reports_paths as $report) {
                if (isset($report['path'])) {
                    Storage::disk('public')->delete($report['path']);
                }
            }
        }

        if ($riser->other_documents_paths) {
            foreach ($riser->other_documents_paths as $doc) {
                if (isset($doc['path'])) {
                    Storage::disk('public')->delete($doc['path']);
                }
            }
        }

        if ($riser->additional_documents) {
            foreach ($riser->additional_documents as $doc) {
                if (isset($doc['path'])) {
                    Storage::disk('public')->delete($doc['path']);
                }
            }
        }

        $riser->delete();

        return redirect()->route('riser.index')
            ->with('success', 'Riser job deleted successfully.');
    }

    /**
     * Show import form
     */
    public function showImportForm()
    {
        return view('panel.riser.import');
    }

    /**
     * Export Riser data to Excel
     */
    public function export(Request $request)
    {
        // You can create a RiserExport class similar to PngExport
        return response()->json(['message' => 'Export functionality to be implemented']);
    }

    /**
     * Get summary statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_jobs' => Riser::count(),
            'workable_jobs' => Riser::where('connections_status', 'workable')->count(),
            'completed_jobs' => Riser::where('conversion_status', 'conv_done')->count(),
            'pending_jobs' => Riser::whereIn('connections_status', ['pdt_pending', 'gc_pending', 'mmt_pending'])->count(),
            'this_month_jobs' => Riser::whereMonth('created_at', now()->month)->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get measurement types by Riser type (AJAX)
     */
    public function getMeasurementTypesByRiserType(Request $request)
    {
        $riserType = $request->input('riser_type');
        
        $measurementTypes = PngMeasurementType::where('is_active', true)
            ->whereIn('png_type', ['riser', 'approach'])
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
