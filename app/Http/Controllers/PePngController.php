<?php

namespace App\Http\Controllers;

use App\Exports\PePngExport;
use App\Http\Requests\PePngRequest;
use App\Imports\PePngImport;
use App\Models\PePng;
use App\Models\Plumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PePngController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PePng::with('plumber');

        // Apply filters if they exist
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('plumber_id')) {
            $query->where('plumber_id', $request->input('plumber_id'));
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('plumbing_date', [$request->input('start_date'), $request->input('end_date')]);
        }

        $pePngs = $query->latest()->paginate(10);
        $plumbers = Plumber::where('status', 'active')->get();

        return view('panel.pe-png.index', compact('pePngs', 'plumbers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $plumbers = Plumber::where('status', 'active')->get();
        return view('panel.pe-png.create', compact('plumbers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PePngRequest $request)
    {
        $data = $request->validated();

        // Handle file uploads
        if ($request->hasFile('scan_copy')) {
            $data['scan_copy_path'] = $request->file('scan_copy')->store('scan_copies', 'public');
        }

        if ($request->hasFile('autocad_drawing')) {
            $data['autocad_drawing_path'] = $request->file('autocad_drawing')->store('autocad_drawings', 'public');
        }

        // Handle JSON data
        if ($request->filled('site_visits')) {
            $data['site_visits'] = json_encode($request->input('site_visits'));
        }

        if ($request->filled('consumption_details')) {
            $data['consumption_details'] = json_encode($request->input('consumption_details'));
        }

        if ($request->filled('free_issue_details')) {
            $data['free_issue_details'] = json_encode($request->input('free_issue_details'));
        }

        PePng::create($data);

        return redirect()->route('pe-png.index')
            ->with('success', 'PE/PNG job created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PePng $pePng)
    {
         $pePng->refresh();
    
    // Debug the JSON data (FIXED to avoid Array to string conversion error)
    \Log::info('Site Visits Raw Data: ' . ($pePng->getOriginal('site_visits') ? $pePng->getOriginal('site_visits') : 'null'));
    \Log::info('Consumption Details Raw Data: ' . ($pePng->getOriginal('consumption_details') ? $pePng->getOriginal('consumption_details') : 'null'));
    
    // No need for additional formatting, let the view handle the display
        return view('panel.pe-png.show', compact('pePng'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PePng $pePng)
    {
        $plumbers = Plumber::where('status', 'active')->get();
        return view('panel.pe-png.edit', compact('pePng', 'plumbers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PePngRequest $request, PePng $pePng)
    {
        $data = $request->validated();

        // Handle file uploads
        if ($request->hasFile('scan_copy')) {
            // Delete old file if exists
            if ($pePng->scan_copy_path) {
                Storage::disk('public')->delete($pePng->scan_copy_path);
            }
            $data['scan_copy_path'] = $request->file('scan_copy')->store('scan_copies', 'public');
        }

        if ($request->hasFile('autocad_drawing')) {
            // Delete old file if exists
            if ($pePng->autocad_drawing_path) {
                Storage::disk('public')->delete($pePng->autocad_drawing_path);
            }
            $data['autocad_drawing_path'] = $request->file('autocad_drawing')->store('autocad_drawings', 'public');
        }

        // Handle JSON data
        if ($request->filled('site_visits')) {
            $data['site_visits'] = json_encode($request->input('site_visits'));
        }

        if ($request->filled('consumption_details')) {
            $data['consumption_details'] = json_encode($request->input('consumption_details'));
        }

        if ($request->filled('free_issue_details')) {
            $data['free_issue_details'] = json_encode($request->input('free_issue_details'));
        }

        $pePng->update($data);

        return redirect()->route('pe-png.index')
            ->with('success', 'PE/PNG job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PePng $pePng)
    {
        // Delete associated files
        if ($pePng->scan_copy_path) {
            Storage::disk('public')->delete($pePng->scan_copy_path);
        }

        if ($pePng->autocad_drawing_path) {
            Storage::disk('public')->delete($pePng->autocad_drawing_path);
        }

        $pePng->delete();

        return redirect()->route('pe-png.index')
            ->with('success', 'PE/PNG job deleted successfully.');
    }

    /**
     * Show import form
     */
    public function showImportForm()
    {
        return view('panel.pe-png.import');
    }

    /**
     * Import PE/PNG data from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new PePngImport, $request->file('excel_file'));

        return redirect()->route('pe-png.index')
            ->with('success', 'PE/PNG data imported successfully.');
    }

    /**
     * Export PE/PNG data to Excel
     */
    public function export(Request $request)
    {
        return Excel::download(new PePngExport($request), 'pe-png-data.xlsx');
    }
}
