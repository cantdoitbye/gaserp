<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\PngExport;
use App\Http\Requests\PngRequest;
use App\Imports\PngImport;
use App\Models\Png;
use App\Models\PngMeasurementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PngController extends Controller
{
 /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    $query = Png::with(['measurementType']);

    // Generate status counts for the report (before applying filters)
    $statusCounts = [
        'total' => Png::count(),
        'workable' => Png::where('connections_status', 'workable')->count(),
        'not_workable' => Png::where('connections_status', 'not_workable')->count(),
        'plb_done' => Png::where('connections_status', 'plb_done')->count(),
        'pdt_pending' => Png::where('connections_status', 'pdt_pending')->count(),
        'gc_pending' => Png::where('connections_status', 'gc_pending')->count(),
        'mmt_pending' => Png::where('connections_status', 'mmt_pending')->count(),
        'conv_pending' => Png::where('connections_status', 'conv_pending')->count(),
        'comm' => Png::where('connections_status', 'comm')->count(),
        'report_pending' => Png::where('connections_status', 'report_pending')->count(),
        'bill_pending' => Png::where('connections_status', 'bill_pending')->count(),
        'bill_received' => Png::where('connections_status', 'bill_received')->count(),
    ];

    // Text-based searches
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

    if ($request->filled('plumber_name')) {
        $query->where('plb_name', 'LIKE', '%' . $request->plumber_name . '%');
    }

    if ($request->filled('pdt_witness_by')) {
        $query->where('pdt_witness_by', 'LIKE', '%' . $request->pdt_witness_by . '%');
    }

    if ($request->filled('mmt_witness_by')) {
        $query->where('mmt_witness_by', 'LIKE', '%' . $request->mmt_witness_by . '%');
    }

    if ($request->filled('meter_number')) {
        $query->where('meter_number', 'LIKE', '%' . $request->meter_number . '%');
    }

    if ($request->filled('ra_bill_no')) {
        $query->where('ra_bill_no', 'LIKE', '%' . $request->ra_bill_no . '%');
    }

    // Dropdown/Select filters
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

    if ($request->filled('conversion_date_from')) {
        $query->whereDate('conversion_date', '>=', $request->conversion_date_from);
    }

    if ($request->filled('conversion_date_to')) {
        $query->whereDate('conversion_date', '<=', $request->conversion_date_to);
    }

    // SLA Days filter
    if ($request->filled('sla_days')) {
        $slaDays = $request->sla_days;
        
        // Only include records that have an agreement_date
        $query->whereNotNull('agreement_date')
              ->whereRaw('DATEDIFF(NOW(), agreement_date) = ?', [$slaDays]);
    }

    // Legacy date filter support (for backward compatibility)
    if ($request->filled('start_date_from') && $request->filled('start_date_to')) {
        $query->whereBetween('agreement_date', [$request->start_date_from, $request->start_date_to]);
    }

    // Sorting
    $sortField = $request->input('sort', 'created_at');
    $sortDirection = $request->input('direction', 'desc');
    
    // Map form field names to database field names
    $fieldMapping = [
        'name' => 'customer_name',
        'plumber_name' => 'plb_name',
        'plumbing_date' => 'plb_date',
    ];
    
    $actualSortField = $fieldMapping[$sortField] ?? $sortField;
    
    // Allowed sort fields for security
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
    $pngs = $query->paginate(15)->withQueryString();

    // Get measurement types for filter dropdown
    $measurementTypes = PngMeasurementType::orderBy('name')->get(['id', 'name']);

    return view('panel.png.index', compact('pngs', 'measurementTypes', 'statusCounts'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $measurementTypes = PngMeasurementType::active()->get();
        return view('panel.png.create', compact('measurementTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    try {
        // $data = $request->validated();
        $data = $request->all();

        // Handle file uploads - convert arrays to JSON strings
        if ($request->hasFile('scan_copy')) {
            $data['scan_copy_path'] = $request->file('scan_copy')->store('png_scan_copies', 'public');
        }

        if ($request->hasFile('autocad_drawing')) {
            $data['autocad_drawing_path'] = $request->file('autocad_drawing')->store('png_autocad_drawings', 'public');
        }

        if ($request->hasFile('certificate')) {
            $data['certificate_path'] = $request->file('certificate')->store('png_certificates', 'public');
        }

        // Handle Job Cards - store as JSON
        if ($request->hasFile('job_cards')) {
            $jobCardsPaths = [];
            foreach ($request->file('job_cards') as $file) {
                $path = $file->store('png_job_cards', 'public');
                $jobCardsPaths[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            // Convert array to JSON string
            $data['job_cards_paths'] = json_encode($jobCardsPaths);
        }

        // Handle AutoCad DWG files - store as JSON
        if ($request->hasFile('autocad_dwg')) {
            $autocadPaths = [];
            foreach ($request->file('autocad_dwg') as $file) {
                $path = $file->store('png_autocad_dwg', 'public');
                $autocadPaths[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            // Convert array to JSON string
            $data['autocad_dwg_paths'] = json_encode($autocadPaths);
        }

        // Handle Site Visit Reports - store as JSON
        if ($request->hasFile('site_visit_reports')) {
            $reportsPaths = [];
            foreach ($request->file('site_visit_reports') as $file) {
                $path = $file->store('png_site_visit_reports', 'public');
                $reportsPaths[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            // Convert array to JSON string
            $data['site_visit_reports_paths'] = json_encode($reportsPaths);
        }

        // Handle Other Documents - store as JSON
        if ($request->hasFile('other_documents')) {
            $otherDocs = [];
            foreach ($request->file('other_documents') as $file) {
                $path = $file->store('png_other_documents', 'public');
                $otherDocs[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            // Convert array to JSON string
            $data['other_documents_paths'] = json_encode($otherDocs);
        }

        // Handle additional documents - store as JSON
        if ($request->hasFile('additional_documents')) {
            $additionalDocs = [];
            foreach ($request->file('additional_documents') as $file) {
                $path = $file->store('png_additional_docs', 'public');
                $additionalDocs[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            // Convert array to JSON string
            $data['additional_documents'] = json_encode($additionalDocs);
        }

        // Handle measurements array - store as measurements_data (matching your model)
        if (isset($data['measurements']) && is_array($data['measurements'])) {
            $data['measurements_data'] = $data['measurements'];
            unset($data['measurements']); // Remove the original measurements key
        }

        // Map form field names to model field names if needed
        if (isset($data['plumber_name'])) {
            $data['plb_name'] = $data['plumber_name']; // Map to your model field
        }
        
        if (isset($data['plumbing_date'])) {
            $data['plb_date'] = $data['plumbing_date']; // Map to your model field
        }

        // Handle required_document_types array - keep as array since model will cast it
        // No need to json_encode since the model handles this with casting

        // Remove the dd() statement and create the record
        $png = Png::create($data);

        return redirect()->route('png.index')
            ->with('success', 'PNG job created successfully.');

    } catch (\Exception $e) {
        
        // Log the error for debugging
        \Log::error('PNG Creation Error: ' . $e->getMessage(), [
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
    public function show(Png $png)
    {
        $png->load('measurementType');
        return view('panel.png.show', compact('png'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Png $png)
    {
        $png->load('measurementType');
        $measurementTypes = PngMeasurementType::active()->get();
        return view('panel.png.edit', compact('png', 'measurementTypes'));
    }

  /**
 * Update the specified PNG job in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\Png  $png
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, Png $png)
{
    try {
        $data = $request->all();

        // Handle single file uploads (replace existing)
        if ($request->hasFile('scan_copy')) {
            // Delete old file if exists
            if ($png->scan_copy_path && Storage::disk('public')->exists($png->scan_copy_path)) {
                Storage::disk('public')->delete($png->scan_copy_path);
            }
            $data['scan_copy_path'] = $request->file('scan_copy')->store('png_scan_copies', 'public');
        }

        if ($request->hasFile('autocad_drawing')) {
            // Delete old file if exists
            if ($png->autocad_drawing_path && Storage::disk('public')->exists($png->autocad_drawing_path)) {
                Storage::disk('public')->delete($png->autocad_drawing_path);
            }
            $data['autocad_drawing_path'] = $request->file('autocad_drawing')->store('png_autocad_drawings', 'public');
        }

        if ($request->hasFile('certificate')) {
            // Delete old file if exists
            if ($png->certificate_path && Storage::disk('public')->exists($png->certificate_path)) {
                Storage::disk('public')->delete($png->certificate_path);
            }
            $data['certificate_path'] = $request->file('certificate')->store('png_certificates', 'public');
        }

        // Handle Job Cards - append to existing files
        if ($request->hasFile('job_cards')) {
            $existingJobCards = $png->job_cards_paths ?? [];
            $newJobCards = [];
            
            foreach ($request->file('job_cards') as $file) {
                $path = $file->store('png_job_cards', 'public');
                $newJobCards[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            
            // Merge existing and new files
            $data['job_cards_paths'] = json_encode(array_merge($existingJobCards, $newJobCards));
        }

        // Handle AutoCad DWG files - append to existing files
        if ($request->hasFile('autocad_dwg')) {
            $existingAutocadFiles = $png->autocad_dwg_paths ?? [];
            $newAutocadFiles = [];
            
            foreach ($request->file('autocad_dwg') as $file) {
                $path = $file->store('png_autocad_dwg', 'public');
                $newAutocadFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            
            // Merge existing and new files
            $data['autocad_dwg_paths'] = json_encode(array_merge($existingAutocadFiles, $newAutocadFiles));
        }

        // Handle Site Visit Reports - append to existing files
        if ($request->hasFile('site_visit_reports')) {
            $existingReports = $png->site_visit_reports_paths ?? [];
            $newReports = [];
            
            foreach ($request->file('site_visit_reports') as $file) {
                $path = $file->store('png_site_visit_reports', 'public');
                $newReports[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            
            // Merge existing and new files
            $data['site_visit_reports_paths'] = json_encode(array_merge($existingReports, $newReports));
        }

        // Handle Other Documents - append to existing files
        if ($request->hasFile('other_documents')) {
            $existingOtherDocs = $png->other_documents_paths ?? [];
            $newOtherDocs = [];
            
            foreach ($request->file('other_documents') as $file) {
                $path = $file->store('png_other_documents', 'public');
                $newOtherDocs[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            
            // Merge existing and new files
            $data['other_documents_paths'] = json_encode(array_merge($existingOtherDocs, $newOtherDocs));
        }

        // Handle Additional Documents - append to existing files
        if ($request->hasFile('additional_documents')) {
            $existingAdditionalDocs = $png->additional_documents ?? [];
            $newAdditionalDocs = [];
            
            foreach ($request->file('additional_documents') as $file) {
                $path = $file->store('png_additional_docs', 'public');
                $newAdditionalDocs[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType()
                ];
            }
            
            // Merge existing and new files
            $data['additional_documents'] = json_encode(array_merge($existingAdditionalDocs, $newAdditionalDocs));
        }

        // Handle measurements array - store as measurements_data (matching your model)
        if (isset($data['measurements']) && is_array($data['measurements'])) {
            $data['measurements_data'] = $data['measurements'];
            unset($data['measurements']); // Remove the original measurements key
        }

        // Map form field names to model field names if needed
        if (isset($data['plumber_name'])) {
            $data['plb_name'] = $data['plumber_name']; // Map to your model field
        }
        
        if (isset($data['plumbing_date'])) {
            $data['plb_date'] = $data['plumbing_date']; // Map to your model field
        }

        // Handle required_document_types array - keep as array since model will cast it
        // No need to json_encode since the model handles this with casting

        // Update the PNG record
        $png->update($data);

        return redirect()->route('png.show', $png->id)
            ->with('success', 'PNG job updated successfully.');

    } catch (\Exception $e) {
        
        // Log the error for debugging
        \Log::error('PNG Update Error: ' . $e->getMessage(), [
            'png_id' => $png->id,
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
    public function destroy(Png $png)
    {
        // Delete associated files
        if ($png->scan_copy_path) {
            Storage::disk('public')->delete($png->scan_copy_path);
        }

        if ($png->autocad_drawing_path) {
            Storage::disk('public')->delete($png->autocad_drawing_path);
        }

        if ($png->certificate_path) {
            Storage::disk('public')->delete($png->certificate_path);
        }

        // Delete job cards
        if ($png->job_cards_paths) {
            foreach ($png->job_cards_paths as $jobCard) {
                if (isset($jobCard['path'])) {
                    Storage::disk('public')->delete($jobCard['path']);
                }
            }
        }

        // Delete AutoCad DWG files
        if ($png->autocad_dwg_paths) {
            foreach ($png->autocad_dwg_paths as $dwgFile) {
                if (isset($dwgFile['path'])) {
                    Storage::disk('public')->delete($dwgFile['path']);
                }
            }
        }

        // Delete site visit reports
        if ($png->site_visit_reports_paths) {
            foreach ($png->site_visit_reports_paths as $report) {
                if (isset($report['path'])) {
                    Storage::disk('public')->delete($report['path']);
                }
            }
        }

        // Delete other documents
        if ($png->other_documents_paths) {
            foreach ($png->other_documents_paths as $doc) {
                if (isset($doc['path'])) {
                    Storage::disk('public')->delete($doc['path']);
                }
            }
        }

        // Delete additional documents (legacy)
        if ($png->additional_documents) {
            foreach ($png->additional_documents as $doc) {
                if (isset($doc['path'])) {
                    Storage::disk('public')->delete($doc['path']);
                }
            }
        }

        $png->delete();

        return redirect()->route('png.index')
            ->with('success', 'PNG job deleted successfully.');
    }

    /**
     * Show import form
     */
    public function showImportForm()
    {
        return view('panel.png.import');
    }

    /**
     * Import PNG data from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        try {
            Excel::import(new PngImport, $request->file('excel_file'));
            return redirect()->route('png.index')
                ->with('success', 'PNG data imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }

    /**
     * Export PNG data to Excel
     */
    public function export(Request $request)
    {
        return Excel::download(new PngExport($request), 'png-data-' . date('Y-m-d-H-i-s') . '.xlsx');
    }

    /**
     * Get summary statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_jobs' => Png::count(),
            'workable_jobs' => Png::where('connections_status', 'workable')->count(),
            'completed_jobs' => Png::where('conversion_status', 'conv_done')->count(),
            'pending_jobs' => Png::whereIn('connections_status', ['pdt_pending', 'gc_pending', 'mmt_pending'])->count(),
            'this_month_jobs' => Png::whereMonth('created_at', now()->month)->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get measurement types by PNG type (AJAX)
     */
    public function getMeasurementTypesByPngType(Request $request)
    {
        $pngType = $request->input('png_type');
        
        $measurementTypes = PngMeasurementType::active()
            ->byPngType($pngType)
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
