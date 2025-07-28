<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlumberRequest;
use App\Models\Plumber;
use Illuminate\Support\Str;


use Illuminate\Http\Request;

class PlumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Plumber::query();

        // Apply search if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        // Apply status filter if provided
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $plumbers = $query->latest()->paginate(10);

        return view('panel.plumbers.index', compact('plumbers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.plumbers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlumberRequest $request)
    {
        // Plumber::create($request->validated());



                   // Get validated data
        $validatedData = $request->validated();
        
        // Generate a unique plumber_id
        $validatedData['plumber_id'] = $this->generatePlumberId();
        
        // Create the plumber
        Plumber::create($validatedData);

        return redirect()->route('plumbers.index')
            ->with('success', 'Plumber created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plumber $plumber)
    {
        // Load associated jobs
        $plumber->load(['pePngs' => function ($query) {
            $query->latest()->take(10);
        }]);
        
        return view('panel.plumbers.show', compact('plumber'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plumber $plumber)
    {
        return view('panel.plumbers.edit', compact('plumber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlumberRequest $request, Plumber $plumber)
    {
        $plumber->update($request->validated());

        return redirect()->route('plumbers.index')
            ->with('success', 'Plumber updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plumber $plumber)
    {
        // Check if plumber has associated jobs
        if ($plumber->pePngs()->count() > 0) {
            return redirect()->route('plumbers.index')
                ->with('error', 'Cannot delete plumber because they have associated jobs.');
        }

        $plumber->delete();

        return redirect()->route('plumbers.index')
            ->with('success', 'Plumber deleted successfully.');
    }


      private function generatePlumberId()
    {
        // Format: PLB-XXXXX (where X is a random alphanumeric character)
        $prefix = 'PLB-';
        
        // Try to generate unique ID up to 10 times
        for ($i = 0; $i < 10; $i++) {
            // Generate a 5 character random string
            $randomStr = strtoupper(Str::random(5));
            $plumberId = $prefix . $randomStr;
            
            // Check if this ID already exists
            if (!Plumber::where('plumber_id', $plumberId)->exists()) {
                return $plumberId;
            }
        }
        
        // If we couldn't generate a unique ID after 10 tries, use timestamp to ensure uniqueness
        return $prefix . strtoupper(Str::random(2)) . time();
    }

}
