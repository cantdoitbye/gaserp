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
  public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new PngImport;
            Excel::import($import, $request->file('excel_file'));
            
            $summary = $import->getImportSummary();
            
            $message = "Import completed! ";
            $message .= "Success: {$summary['success_count']}, ";
            $message .= "Skipped: {$summary['skip_count']}, ";
            $message .= "Errors: {$summary['error_count']}";
            
            if ($summary['error_count'] > 0) {
                // Log detailed errors
                Log::warning('PNG Import had errors', $summary['errors']);
                
                // Show first few errors to user
                $errorPreview = array_slice($summary['errors'], 0, 5);
                $message .= "\n\nFirst few errors:\n" . implode("\n", $errorPreview);
                
                if ($summary['error_count'] > 5) {
                    $message .= "\n\n... and " . ($summary['error_count'] - 5) . " more errors. Check logs for details.";
                }
                
                return redirect()->route('png.index')
                    ->with('error', $message);
            }
            
            return redirect()->route('png.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            Log::error('PNG Import Critical Error: ' . $e->getMessage(), [
                'file' => $request->file('file')->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $errorMessage = 'Critical import error: ' . $e->getMessage();
            
            // Provide helpful hints based on common error patterns
            if (strpos($e->getMessage(), 'string') !== false) {
                $errorMessage .= "\n\nHint: Check that your Excel columns match the expected format. Service Order Number should be text, not numbers.";
            }
            
            if (strpos($e->getMessage(), 'date') !== false) {
                $errorMessage .= "\n\nHint: Make sure date columns are properly formatted in Excel (YYYY-MM-DD or MM/DD/YYYY).";
            }
            
            return redirect()->back()
                ->with('error', $errorMessage);
        }
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
}