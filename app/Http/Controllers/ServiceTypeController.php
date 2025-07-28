<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceTypeController extends Controller
{
        /**
     * Display a listing of the service types.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceTypes = ServiceType::orderBy('name')->paginate(10);
        return view('panel.service-types.index', compact('serviceTypes'));
    }

    /**
     * Show the form for creating a new service type.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.service-types.create');
    }

    /**
     * Store a newly created service type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:service_types,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        ServiceType::create([
            'name' => strtolower($request->name),
        ]);

        return redirect()->route('service-types.index')
            ->with('success', 'Service type created successfully.');
    }


     public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:service_types,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $serviceType = ServiceType::create([
            'name' => strtolower($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service type created successfully',
            'serviceType' => $serviceType
        ]);
    }

    /**
     * Show the form for editing the specified service type.
     *
     * @param  \App\Models\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceType $serviceType)
    {
        return view('panel.service-types.edit', compact('serviceType'));
    }

    /**
     * Update the specified service type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceType $serviceType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:service_types,name,' . $serviceType->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $serviceType->update([
            'name' => strtolower($request->name),
        ]);

        return redirect()->route('service-types.index')
            ->with('success', 'Service type updated successfully.');
    }

    /**
     * Remove the specified service type from storage.
     *
     * @param  \App\Models\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceType $serviceType)
    {
        // Check if any projects are using this service type
        $projectCount = Project::where('service_type_id', $serviceType->id)->count();
        
        if ($projectCount > 0) {
            return redirect()->route('service-types.index')
                ->with('error', 'Cannot delete this service type because it is used by ' . $projectCount . ' project(s).');
        }
        
        $serviceType->delete();
        
        return redirect()->route('service-types.index')
            ->with('success', 'Service type deleted successfully.');
    }

}
