<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Png;
use App\Models\PngMeasurementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PngImport;
use App\Exports\PngExport;

class PngController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Png::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('service_order_no', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_no', 'like', "%{$search}%")
                  ->orWhere('po_number', 'like', "%{$search}%")
                  ->orWhere('house_no', 'like', "%{$search}%")
                  ->orWhere('application_no', 'like', "%{$search}%")
                  ->orWhere('meter_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('project_id')) {
    $query->where('project_id', $request->project_id);
}

        // Filter by connections status
        if ($request->filled('connections_status')) {
            $query->where('connections_status', $request->connections_status);
        }

        // Filter by plan type
        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }

        // Filter by booking method
        if ($request->filled('booking_by')) {
            $query->where('booking_by', $request->booking_by);
        }

        // Date range filters
        if ($request->filled('start_date_from')) {
            $query->where('start_date', '>=', $request->start_date_from);
        }
        
        if ($request->filled('start_date_to')) {
            $query->where('start_date', '<=', $request->start_date_to);
        }

        // Status counts for dashboard
        $statusCounts = [
            'total' => Png::count(),
            'workable' => Png::where('connections_status', 'workable')->count(),
            'plb_done' => Png::where('connections_status', 'plb_done')->count(),
            'pending' => Png::whereIn('connections_status', ['pdt_pending', 'gc_pending', 'mmt_pending', 'conv_pending'])->count(),
            'completed' => Png::where('connections_status', 'comm')->count(),
        ];

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        $query->orderBy('created_at', 'desc');

        // Pagination
        $pngs = $query->paginate(15)->withQueryString();

        return view('panel.png.index', compact('pngs', 'statusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Remove dependency on measurement types for static fields
        return view('panel.png.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            // Validate required fields
            $request->validate([
                'service_order_no' => 'required|string|max:255',
                'customer_name' => 'required|string|max:255',
                'agreement_date' => 'required|date',
                'start_date' => 'nullable|date',
                'plb_date' => 'nullable|date',
                'gc_date' => 'nullable|date',
                'mmt_date' => 'nullable|date',
                'conversion_date' => 'nullable|date',
            ]);

            // Handle file uploads
            if ($request->hasFile('scan_copy')) {
                $data['scan_copy_path'] = $request->file('scan_copy')->store('png_scan_copies', 'public');
            }

            if ($request->hasFile('autocad_drawing')) {
                $data['autocad_drawing_path'] = $request->file('autocad_drawing')->store('png_autocad_drawings', 'public');
            }

            if ($request->hasFile('certificate')) {
                $data['certificate_path'] = $request->file('certificate')->store('png_certificates', 'public');
            }

            // Handle multiple file uploads
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
                $data['job_cards_paths'] = json_encode($jobCardsPaths);
            }

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
                $data['autocad_dwg_paths'] = json_encode($autocadPaths);
            }

            if ($request->hasFile('site_visit_reports')) {
                $siteVisitPaths = [];
                foreach ($request->file('site_visit_reports') as $file) {
                    $path = $file->store('png_site_visit_reports', 'public');
                    $siteVisitPaths[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getClientMimeType()
                    ];
                }
                $data['site_visit_reports_paths'] = json_encode($siteVisitPaths);
            }

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
                $data['other_documents_paths'] = json_encode($otherDocs);
            }

            // Auto-calculate totals if individual measurements are provided
            if ($request->filled([
                'gi_guard_to_main_valve_half_inch',
                'gi_main_valve_to_meter_half_inch', 
                'gi_meter_to_geyser_half_inch',
                'gi_geyser_point_half_inch',
                'extra_kitchen_point'
            ])) {
                $data['total_gi'] = ($data['gi_guard_to_main_valve_half_inch'] ?? 0) +
                                   ($data['gi_main_valve_to_meter_half_inch'] ?? 0) +
                                   ($data['gi_meter_to_geyser_half_inch'] ?? 0) +
                                   ($data['gi_geyser_point_half_inch'] ?? 0) +
                                   ($data['extra_kitchen_point'] ?? 0);
            }

            if ($request->filled(['open_cut_20mm', 'boring_20mm'])) {
                $data['total_mdpe_pipe_20mm'] = ($data['open_cut_20mm'] ?? 0) + ($data['boring_20mm'] ?? 0);
            }

            // Clean empty numeric fields
            $numericFields = [
                'gi_guard_to_main_valve_half_inch', 'gi_main_valve_to_meter_half_inch',
                'gi_meter_to_geyser_half_inch', 'gi_geyser_point_half_inch', 'extra_kitchen_point',
                'total_gi', 'high_press_1_6_reg', 'low_press_2_5_reg', 'reg_qty', 'gas_tap',
                'valve_half_inch', 'gi_coupling_half_inch', 'gi_elbow_half_inch', 'clamp_half_inch',
                'gi_tee_half_inch', 'anaconda', 'open_cut_20mm', 'boring_20mm', 'total_mdpe_pipe_20mm',
                'tee_20mm', 'rcc_guard_20mm', 'gf_coupler_20mm', 'gf_saddle_32x20mm',
                'gf_saddle_63x20mm', 'gf_saddle_63x32mm', 'gf_saddle_125x32', 'gf_saddle_90x20mm',
                'gf_reducer_32x20mm', 'conversion_payment', 'meter_reading'
            ];

            foreach ($numericFields as $field) {
                if (isset($data[$field]) && $data[$field] === '') {
                    $data[$field] = null;
                }
            }

            $png = Png::create($data);

            return redirect()->route('png.index')
                ->with('success', 'PNG job created successfully.');

        } catch (\Exception $e) {
            Log::error('PNG Creation Error: ' . $e->getMessage(), [
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
        return view('panel.png.show', compact('png'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Png $png)
    {
        return view('panel.png.edit', compact('png'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Png $png)
    {
        try {
            $data = $request->all();

            // Validate required fields
            $request->validate([
                'service_order_no' => 'required|string|max:255',
                'customer_name' => 'required|string|max:255',
                'agreement_date' => 'required|date',
                'start_date' => 'nullable|date',
                'plb_date' => 'nullable|date',
                'gc_date' => 'nullable|date',
                'mmt_date' => 'nullable|date',
                'conversion_date' => 'nullable|date',
            ]);

            // Handle file uploads (same as store method)
            if ($request->hasFile('scan_copy')) {
                // Delete old file if exists
                if ($png->scan_copy_path) {
                    Storage::disk('public')->delete($png->scan_copy_path);
                }
                $data['scan_copy_path'] = $request->file('scan_copy')->store('png_scan_copies', 'public');
            }

            if ($request->hasFile('autocad_drawing')) {
                if ($png->autocad_drawing_path) {
                    Storage::disk('public')->delete($png->autocad_drawing_path);
                }
                $data['autocad_drawing_path'] = $request->file('autocad_drawing')->store('png_autocad_drawings', 'public');
            }

            if ($request->hasFile('certificate')) {
                if ($png->certificate_path) {
                    Storage::disk('public')->delete($png->certificate_path);
                }
                $data['certificate_path'] = $request->file('certificate')->store('png_certificates', 'public');
            }

            // Handle multiple file uploads (similar to store)
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
                // Merge with existing files if needed
                $existingFiles = $png->job_cards_paths ?? [];
                $data['job_cards_paths'] = json_encode(array_merge($existingFiles, $jobCardsPaths));
            }

            // Auto-calculate totals
            if ($request->filled([
                'gi_guard_to_main_valve_half_inch',
                'gi_main_valve_to_meter_half_inch', 
                'gi_meter_to_geyser_half_inch',
                'gi_geyser_point_half_inch',
                'extra_kitchen_point'
            ])) {
                $data['total_gi'] = ($data['gi_guard_to_main_valve_half_inch'] ?? 0) +
                                   ($data['gi_main_valve_to_meter_half_inch'] ?? 0) +
                                   ($data['gi_meter_to_geyser_half_inch'] ?? 0) +
                                   ($data['gi_geyser_point_half_inch'] ?? 0) +
                                   ($data['extra_kitchen_point'] ?? 0);
            }

            if ($request->filled(['open_cut_20mm', 'boring_20mm'])) {
                $data['total_mdpe_pipe_20mm'] = ($data['open_cut_20mm'] ?? 0) + ($data['boring_20mm'] ?? 0);
            }

            // Clean empty numeric fields
            $numericFields = [
                'gi_guard_to_main_valve_half_inch', 'gi_main_valve_to_meter_half_inch',
                'gi_meter_to_geyser_half_inch', 'gi_geyser_point_half_inch', 'extra_kitchen_point',
                'total_gi', 'high_press_1_6_reg', 'low_press_2_5_reg', 'reg_qty', 'gas_tap',
                'valve_half_inch', 'gi_coupling_half_inch', 'gi_elbow_half_inch', 'clamp_half_inch',
                'gi_tee_half_inch', 'anaconda', 'open_cut_20mm', 'boring_20mm', 'total_mdpe_pipe_20mm',
                'tee_20mm', 'rcc_guard_20mm', 'gf_coupler_20mm', 'gf_saddle_32x20mm',
                'gf_saddle_63x20mm', 'gf_saddle_63x32mm', 'gf_saddle_125x32', 'gf_saddle_90x20mm',
                'gf_reducer_32x20mm', 'conversion_payment', 'meter_reading'
            ];

            foreach ($numericFields as $field) {
                if (isset($data[$field]) && $data[$field] === '') {
                    $data[$field] = null;
                }
            }

            $png->update($data);

            return redirect()->route('png.index')
                ->with('success', 'PNG job updated successfully.');

        } catch (\Exception $e) {
            Log::error('PNG Update Error: ' . $e->getMessage(), [
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
        try {
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

            // Delete multiple files
            if ($png->job_cards_paths) {
                foreach ($png->job_cards_paths as $file) {
                    if (isset($file['path'])) {
                        Storage::disk('public')->delete($file['path']);
                    }
                }
            }

            $png->delete();

            return redirect()->route('png.index')
                ->with('success', 'PNG job deleted successfully.');

        } catch (\Exception $e) {
            Log::error('PNG Deletion Error: ' . $e->getMessage());
            
            return redirect()->route('png.index')
                ->with('error', 'Error occurred while deleting PNG job.');
        }
    }

     /**
     * Download Excel import template
     */
    public function downloadTemplate()
    {
        try {
            return Excel::download(new \App\Exports\PngImportTemplate, 'png_import_template.xlsx');
        } catch (\Exception $e) {
            Log::error('PNG Template Download Error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Error downloading template: ' . $e->getMessage());
        }
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
/**
     * Import PNG data from Excel with improved error handling
     */
    public function import(Request $request)
    {
        // Validate the request first
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240', // max 10MB
        ], [
            'excel_file.required' => 'Please select an Excel file to import.',
            'excel_file.file' => 'The uploaded file is not valid.',
            'excel_file.mimes' => 'Please upload a valid Excel file (.xlsx or .xls).',
            'excel_file.max' => 'The file size should not exceed 10MB.',
        ]);

        // Check if file was actually uploaded
        if (!$request->hasFile('excel_file')) {
            return redirect()->back()
                ->with('error', 'No file was uploaded. Please select an Excel file.')
                ->withInput();
        }

        $file = $request->file('excel_file');

        // Additional file validation
        if (!$file->isValid()) {
            return redirect()->back()
                ->with('error', 'The uploaded file is corrupted or invalid.')
                ->withInput();
        }

        try {
            // Log the import attempt
            \Log::info('PNG Import started', [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'user_id' => auth()->id(),
                'options' => [
                    'skip_duplicates' => $request->boolean('skip_duplicates'),
                    'update_duplicates' => $request->boolean('update_duplicates'),
                    'validate_only' => $request->boolean('validate_only')
                ]
            ]);

            // Create a temporary file to ensure file persistence during import
            $tempPath = $file->store('temp');
            
            // Create import instance with options
            $skipDuplicates = $request->boolean('skip_duplicates', true);
            $updateDuplicates = $request->boolean('update_duplicates', false);
            $validateOnly = $request->boolean('validate_only', false);
            
            $import = new PngImport($skipDuplicates, $updateDuplicates);
            
            // Import the data
            Excel::import($import, storage_path('app/' . $tempPath));
            
            // Clean up temporary file
            \Storage::delete($tempPath);
            
            // Get import summary
            $summary = $import->getImportSummary();
            
            \Log::info('PNG Import completed', $summary);
            
            // Handle validation-only mode
            if ($validateOnly) {
                return $this->handleValidationOnlyResponse($summary);
            }
            
            // Handle normal import response
            return $this->handleImportResponse($summary);
                
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Handle validation errors from the import
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            \Log::error('PNG Import validation failed', [
                'errors' => $errorMessages,
                'file_name' => $file->getClientOriginalName()
            ]);
            
            return redirect()->back()
                ->with('error', 'Import failed due to validation errors.')
                ->with('import_errors', array_slice($errorMessages, 0, 20)) // Limit to first 20 errors
                ->with('import_summary', count($errorMessages) . ' validation errors found.')
                ->withInput();
                
        } catch (\Exception $e) {
            \Log::error('PNG Import failed with exception', [
                'error' => $e->getMessage(),
                'file_name' => $request->hasFile('excel_file') ? $file->getClientOriginalName() : 'Unknown',
                'line' => $e->getLine(),
                'file_path' => $e->getFile()
            ]);
            
            // Clean up temporary file if it exists
            if (isset($tempPath)) {
                \Storage::delete($tempPath);
            }
            
            $errorMessage = $this->getHumanReadableImportError($e->getMessage());
            
            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }

    /**
     * Handle validation-only response
     */
    private function handleValidationOnlyResponse($summary)
    {
        if ($summary['error_count'] > 0) {
            $message = "Validation completed: Found {$summary['error_count']} errors in {$summary['total_processed']} rows.";
            
            return redirect()->back()
                ->with('warning', $message)
                ->with('import_errors', array_slice($summary['errors'], 0, 50)) // Show up to 50 errors
                ->with('import_summary', $message)
                ->withInput();
        } else {
            $message = "Validation successful: All {$summary['total_processed']} rows are valid and ready for import.";
            
            return redirect()->back()
                ->with('success', $message)
                ->withInput();
        }
    }

    /**
     * Handle normal import response
     */
    private function handleImportResponse($summary)
    {
        // Build response message
        $messageParts = [];
        $messageType = 'success';
        
        if ($summary['success_count'] > 0) {
            $messageParts[] = "Successfully imported {$summary['success_count']} records";
        }
        
        if ($summary['update_count'] > 0) {
            $messageParts[] = "Updated {$summary['update_count']} existing records";
        }
        
        if ($summary['skip_count'] > 0) {
            $messageParts[] = "Skipped {$summary['skip_count']} rows";
            if ($summary['success_count'] === 0 && $summary['update_count'] === 0) {
                $messageType = 'warning';
            }
        }
        
        if ($summary['error_count'] > 0) {
            $messageParts[] = "Encountered {$summary['error_count']} errors";
            $messageType = $summary['success_count'] > 0 || $summary['update_count'] > 0 ? 'warning' : 'error';
        }
        
        $message = implode(', ', $messageParts) . '.';
        
        // If no records were processed successfully
        if ($summary['success_count'] === 0 && $summary['update_count'] === 0) {
            return redirect()->back()
                ->with('error', $message)
                ->with('import_errors', array_slice($summary['errors'], 0, 50))
                ->with('import_summary', 'No records were imported successfully.')
                ->withInput();
        }
        
        // If there were errors but some success
        if ($summary['error_count'] > 0) {
            return redirect()->route('png.index')
                ->with($messageType, $message)
                ->with('import_errors', array_slice($summary['errors'], 0, 50))
                ->with('import_summary', $message);
        }
        
        // Complete success
        return redirect()->route('png.index')
            ->with('success', $message);
    }

    /**
     * Convert technical import errors to user-friendly messages
     */
    private function getHumanReadableImportError($error): string
    {
        if (strpos($error, 'Column count doesn\'t match') !== false) {
            return 'Import failed: The Excel file structure doesn\'t match the expected format. Please download and use the provided template.';
        }
        
        if (strpos($error, 'SQLSTATE') !== false) {
            if (strpos($error, 'Duplicate entry') !== false) {
                return 'Import failed: Duplicate records found. Please check your data for duplicate Service Order Numbers or enable the "Skip duplicates" option.';
            }
            if (strpos($error, 'Data truncated') !== false) {
                return 'Import failed: Some data values are invalid or too long. Please check connection status, plan type, and text field lengths.';
            }
            return 'Import failed: Database error occurred. Please check your data format and try again.';
        }
        
        if (strpos($error, 'file') !== false && strpos($error, 'readable') !== false) {
            return 'Import failed: Cannot read the uploaded file. Please ensure the file is not corrupted and try again.';
        }
        
        if (strpos($error, 'memory') !== false) {
            return 'Import failed: File is too large to process. Please try importing a smaller file or split your data into multiple files.';
        }
        
        return 'Import failed: ' . $error;
    }

    /**
     * Export PNG data to Excel
     */
    public function export(Request $request)
    {
        try {
            return Excel::download(new PngExport($request->all()), 'png_data_' . date('Y-m-d') . '.xlsx');
        } catch (\Exception $e) {
            Log::error('PNG Export Error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Error exporting data: ' . $e->getMessage());
        }
    }

    /**
     * Get PNG statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total' => Png::count(),
            'by_status' => Png::selectRaw('connections_status, COUNT(*) as count')
                ->groupBy('connections_status')
                ->pluck('count', 'connections_status'),
            'by_plan_type' => Png::selectRaw('plan_type, COUNT(*) as count')
                ->groupBy('plan_type')
                ->pluck('count', 'plan_type'),
            'by_booking_method' => Png::selectRaw('booking_by, COUNT(*) as count')
                ->groupBy('booking_by')
                ->pluck('count', 'booking_by'),
            'monthly_trends' => Png::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->take(12)
                ->get()
        ];

        return response()->json($stats);
    }

    /**
     * Bulk status update
     */
    public function bulkStatusUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:pngs,id',
            'status' => 'required|string'
        ]);

        try {
            Png::whereIn('id', $request->ids)
                ->update(['connections_status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated for ' . count($request->ids) . ' records.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download file
     */
    public function downloadFile($type, $filename)
    {
        $path = "png_{$type}/" . $filename;
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }
        
        return Storage::disk('public')->download($path);
    }


/**
     * Bulk delete multiple PNG records
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|string',
        ]);

        try {
            // Parse the comma-separated IDs
            $selectedIds = explode(',', $request->selected_ids);
            $selectedIds = array_filter(array_map('trim', $selectedIds));

            if (empty($selectedIds)) {
                return redirect()->back()
                    ->with('error', 'No valid IDs provided for deletion.');
            }

            // Validate that all IDs are numeric
            foreach ($selectedIds as $id) {
                if (!is_numeric($id)) {
                    return redirect()->back()
                        ->with('error', 'Invalid ID format provided.');
                }
            }

            // Get the PNG records to be deleted for logging
            $pngsToDelete = Png::whereIn('id', $selectedIds)->get();
            
            if ($pngsToDelete->isEmpty()) {
                return redirect()->back()
                    ->with('warning', 'No PNG jobs found with the provided IDs.');
            }

            $actualCount = $pngsToDelete->count();
            $requestedCount = count($selectedIds);

            // Log the bulk deletion attempt
            \Log::info('Bulk PNG deletion initiated', [
                'user_id' => auth()->id(),
                'requested_ids' => $selectedIds,
                'found_records' => $actualCount,
                'records' => $pngsToDelete->pluck('service_order_no', 'id')->toArray()
            ]);

            // Delete associated files first (if any)
            foreach ($pngsToDelete as $png) {
                // Delete scan copy
                if ($png->scan_copy_path && 
Storage::disk('public')->exists($png->scan_copy_path)) {
                    Storage::disk('public')->delete($png->scan_copy_path);
                }

                // Delete autocad drawing
                if ($png->autocad_drawing_path && 
Storage::disk('public')->exists($png->autocad_drawing_path)) {
                    Storage::disk('public')->delete($png->autocad_drawing_path);
                }

                // Delete certificate
                if ($png->certificate_path && 
Storage::disk('public')->exists($png->certificate_path)) {
                    Storage::disk('public')->delete($png->certificate_path);
                }

                // Delete job cards files
                if ($png->job_cards_paths) {
                    $jobCardPaths = is_string($png->job_cards_paths) 
                        ? json_decode($png->job_cards_paths, true) 
                        : $png->job_cards_paths;
                    
                    if (is_array($jobCardPaths)) {
                        foreach ($jobCardPaths as $path) {
                            if (is_array($path) && isset($path['path'])) {
                                $filePath = $path['path'];
                            } else {
                                $filePath = $path;
                            }
                            
                            if ($filePath && Storage::disk('public')->exists($filePath)) {
                                Storage::disk('public')->delete($filePath);
                            }
                        }
                    }
                }

                // Delete other document files
                if ($png->other_documents_paths) {
                    $otherDocPaths = is_string($png->other_documents_paths) 
                        ? json_decode($png->other_documents_paths, true) 
                        : $png->other_documents_paths;
                    
                    if (is_array($otherDocPaths)) {
                        foreach ($otherDocPaths as $path) {
                            if (is_array($path) && isset($path['path'])) {
                                $filePath = $path['path'];
                            } else {
                                $filePath = $path;
                            }
                            
                            if ($filePath && Storage::disk('public')->exists($filePath)) {
                                Storage::disk('public')->delete($filePath);
                            }
                        }
                    }
                }
            }

            // Perform the bulk deletion
            $deletedCount = Png::whereIn('id', $selectedIds)->delete();

            // Log the result
            \Log::info('Bulk PNG deletion completed', [
                'user_id' => auth()->id(),
                'requested_count' => $requestedCount,
                'found_count' => $actualCount,
                'deleted_count' => $deletedCount
            ]);

            // Prepare success/warning message
            $message = "Successfully deleted {$deletedCount} PNG job(s).";
            
            if ($requestedCount > $actualCount) {
                $notFoundCount = $requestedCount - $actualCount;
                $message .= " Note: {$notFoundCount} job(s) were not found and may have been 
already deleted.";
                $messageType = 'warning';
            } else {
                $messageType = 'success';
            }

            return redirect()->route('png.index')
                ->with($messageType, $message);

        } catch (\Exception $e) {
            \Log::error('Bulk PNG deletion failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'requested_ids' => $request->selected_ids,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while deleting the PNG jobs: ' . 
$e->getMessage());
        }
    }
}
