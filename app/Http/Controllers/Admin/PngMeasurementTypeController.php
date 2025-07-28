<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PngMeasurementType;


class PngMeasurementTypeController extends Controller
{
    /**
     * Display a listing of measurement types.
     */
    public function index()
    {
        $measurementTypes = PngMeasurementType::orderBy('created_at', 'desc')->paginate(10);
        return view('panel.png-measurement-types.index', compact('measurementTypes'));
    }

    /**
     * Show the form for creating a new measurement type.
     */
    public function create()
    {
        $pngTypes = PngMeasurementType::getPngTypeOptions();
        $fieldTypes = PngMeasurementType::getFieldTypes();
        
        return view('panel.png-measurement-types.create', compact('pngTypes', 'fieldTypes'));
    }

    /**
     * Store a newly created measurement type.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'png_type' => 'required|string',
            'description' => 'nullable|string',
            'measurement_fields' => 'required|array|min:1',
            'measurement_fields.*.name' => 'required|string|distinct',
            'measurement_fields.*.label' => 'required|string',
            'measurement_fields.*.type' => 'required|string',
            'measurement_fields.*.category' => 'required|string',
        ]);

        $measurementFields = [];
        foreach ($request->measurement_fields as $field) {
            $measurementFields[] = [
                'name' => $field['name'],
                'label' => $field['label'],
                'type' => $field['type'],
                'unit' => $field['unit'] ?? null,
                'required' => isset($field['required']) && $field['required'] === 'on',
                'category' => $field['category'],
                'calculated' => isset($field['calculated']) && $field['calculated'] === 'on',
                'calculation_formula' => $field['calculation_formula'] ?? null,
                'options' => $field['type'] === 'select' ? ($field['options'] ?? []) : null
            ];
        }

        PngMeasurementType::create([
            'name' => $request->name,
            'png_type' => $request->png_type,
            'description' => $request->description,
            'measurement_fields' => $measurementFields,
            'is_active' => true
        ]);

        return redirect()->route('png-measurement-types.index')
            ->with('success', 'Measurement type created successfully.');
    }

    /**
     * Display the specified measurement type.
     */
    public function show(PngMeasurementType $pngMeasurementType)
    {
        return view('panel.png-measurement-types.show', compact('pngMeasurementType'));
    }

    /**
     * Show the form for editing the specified measurement type.
     */
    public function edit(PngMeasurementType $pngMeasurementType)
    {
        $pngTypes = PngMeasurementType::getPngTypeOptions();
        $fieldTypes = PngMeasurementType::getFieldTypes();
        
        return view('panel.png-measurement-types.edit', compact('pngMeasurementType', 'pngTypes', 'fieldTypes'));
    }

    /**
     * Update the specified measurement type.
     */
    public function update(Request $request, PngMeasurementType $pngMeasurementType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'png_type' => 'required|string',
            'description' => 'nullable|string',
            'measurement_fields' => 'required|array|min:1',
            'measurement_fields.*.name' => 'required|string|distinct',
            'measurement_fields.*.label' => 'required|string',
            'measurement_fields.*.type' => 'required|string',
            'measurement_fields.*.category' => 'required|string',
        ]);

        $measurementFields = [];
        foreach ($request->measurement_fields as $field) {
            $measurementFields[] = [
                'name' => $field['name'],
                'label' => $field['label'],
                'type' => $field['type'],
                'unit' => $field['unit'] ?? null,
                'required' => isset($field['required']) && $field['required'] === 'on',
                'category' => $field['category'],
                'calculated' => isset($field['calculated']) && $field['calculated'] === 'on',
                'calculation_formula' => $field['calculation_formula'] ?? null,
                'options' => $field['type'] === 'select' ? ($field['options'] ?? []) : null
            ];
        }

        $pngMeasurementType->update([
            'name' => $request->name,
            'png_type' => $request->png_type,
            'description' => $request->description,
            'measurement_fields' => $measurementFields
        ]);

        return redirect()->route('png-measurement-types.index')
            ->with('success', 'Measurement type updated successfully.');
    }

    /**
     * Remove the specified measurement type.
     */
    public function destroy(PngMeasurementType $pngMeasurementType)
    {
        // Check if any PNG jobs are using this measurement type
        if ($pngMeasurementType->pngs()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete measurement type that is being used by PNG jobs.');
        }

        $pngMeasurementType->delete();

        return redirect()->route('png-measurement-types.index')
            ->with('success', 'Measurement type deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(PngMeasurementType $pngMeasurementType)
    {
        $pngMeasurementType->update([
            'is_active' => !$pngMeasurementType->is_active
        ]);

        $status = $pngMeasurementType->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "Measurement type {$status} successfully.");
    }

    /**
     * Get measurement types by PNG type (AJAX)
     */
    public function getByPngType(Request $request)
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
    public function getMeasurementFields(PngMeasurementType $pngMeasurementType)
    {
        return response()->json([
            'measurement_type' => $pngMeasurementType,
            'fields' => $pngMeasurementType->measurement_fields
        ]);
    }

    /**
     * Create default measurement types
     */
    public function createDefaults()
    {
        $defaultTypes = [
            [
                'name' => 'Standard Flat',
                'png_type' => 'flat',
                'description' => 'Standard measurement type for flat connections',
                'measurement_fields' => PngMeasurementType::getDefaultFields('flat')
            ],
            [
                'name' => 'Standard House',
                'png_type' => 'house',
                'description' => 'Standard measurement type for house connections',
                'measurement_fields' => PngMeasurementType::getDefaultFields('house')
            ],
            [
                'name' => 'Standard Bungalow',
                'png_type' => 'bungalow',
                'description' => 'Standard measurement type for bungalow connections',
                'measurement_fields' => PngMeasurementType::getDefaultFields('bungalow')
            ]
        ];

        foreach ($defaultTypes as $type) {
            PngMeasurementType::firstOrCreate(
                ['name' => $type['name'], 'png_type' => $type['png_type']],
                $type
            );
        }

        return redirect()->back()
            ->with('success', 'Default measurement types created successfully.');
    }
}
