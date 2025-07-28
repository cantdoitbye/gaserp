<?php

namespace App\Http\Controllers;

use App\Models\LegalDocumentType;
use App\Models\Project;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\Http\Response
     */
  public function index(Request $request)
    {
        $query = Project::with('serviceType');

        // Apply filters with support for multiple selections
        if ($request->has('status') && !empty($request->status)) {
            // Check if status is an array (multiple selections)
            if (is_array($request->status)) {
                $query->whereIn('status', $request->status);
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->has('location') && !empty($request->location)) {
            // Check if location is an array (multiple selections)
            if (is_array($request->location)) {
                $query->where(function($q) use ($request) {
                    foreach ($request->location as $location) {
                        $q->orWhere('location', 'like', '%' . $location . '%');
                    }
                });
            } else {
                $query->where('location', 'like', '%' . $request->location . '%');
            }
        }

        if ($request->has('client_name') && !empty($request->client_name)) {
            // Check if client_name is an array (multiple selections)
            if (is_array($request->client_name)) {
                $query->where(function($q) use ($request) {
                    foreach ($request->client_name as $client) {
                        $q->orWhere('client_name', 'like', '%' . $client . '%');
                    }
                });
            } else {
                $query->where('client_name', 'like', '%' . $request->client_name . '%');
            }
        }

        // New filter for service_type_id
        if ($request->has('service_type_id') && !empty($request->service_type_id)) {
            // Check if service_type_id is an array (multiple selections)
            if (is_array($request->service_type_id)) {
                $query->whereIn('service_type_id', $request->service_type_id);
            } else {
                $query->where('service_type_id', $request->service_type_id);
            }
        }

        // New filter for tender_id
        if ($request->has('tender_id') && !empty($request->tender_id)) {
            // Check if tender_id is an array (multiple selections)
            if (is_array($request->tender_id)) {
                $query->where(function($q) use ($request) {
                    foreach ($request->tender_id as $tenderId) {
                        $q->orWhere('tender_id', 'like', '%' . $tenderId . '%');
                    }
                });
            } else {
                $query->where('tender_id', 'like', '%' . $request->tender_id . '%');
            }
        }

        // New filter for contract_number
        if ($request->has('contract_number') && !empty($request->contract_number)) {
            // Check if contract_number is an array (multiple selections)
            if (is_array($request->contract_number)) {
                $query->where(function($q) use ($request) {
                    foreach ($request->contract_number as $contractNumber) {
                        $q->orWhere('contract_number', 'like', '%' . $contractNumber . '%');
                    }
                });
            } else {
                $query->where('contract_number', 'like', '%' . $request->contract_number . '%');
            }
        }

        // Apply sorting
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        $projects = $query->paginate(10);

        // Get unique values for filter dropdowns
        $locations = Project::distinct('location')->pluck('location')->filter();
        $clients = Project::distinct('client_name')->pluck('client_name')->filter();
        $tenderIds = Project::distinct('tender_id')->pluck('tender_id')->filter();
        $contractNumbers = Project::distinct('contract_number')->pluck('contract_number')->filter();
        $serviceTypes = ServiceType::pluck('name', 'id');

        return view('panel.projects.index', compact(
            'projects', 
            'locations', 
            'clients', 
            'serviceTypes',
            'tenderIds',
            'contractNumbers'
        ));
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
                $documentTypes = LegalDocumentType::all();
    $serviceTypes = ServiceType::pluck('name', 'id');

        return view('panel.projects.create', compact('documentTypes', 'serviceTypes'));
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contract_number' => 'nullable|string|max:50',
            'tender_id' => 'nullable|string|max:100',
            'prebid_meeting_date' => 'nullable|date',
            'tender_submit_date' => 'nullable|date',
            'price_open_percentage' => 'nullable|numeric|min:0|max:100',
            'kick_off_meeting_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'client_name' => 'nullable|string|max:255',
            'client_contact' => 'nullable|string|max:255',
            'project_manager' => 'nullable|string|max:255',
            'pipeline_length' => 'nullable|numeric|min:0',
            'pipeline_type' => 'nullable|string|max:100',
            'pipeline_material' => 'nullable|string|max:100',
            'service_type' => 'nullable|in:installation,repair,maintenance,inspection,mixed',
            'status' => 'required|in:pending,active,completed,cancelled',
            'contact_value' => 'nullable|numeric|min:0',
            'contract_value_consumption' => 'nullable|numeric|min:0',
            'amendment_date' => 'nullable|date',
            'amendment_value' => 'nullable|numeric',
            'labour_licence_number' => 'nullable|string|max:100',
            'licence_application_date' => 'nullable|date',
            'required_document_types' => 'nullable|array',
            'required_document_types.*' => 'exists:legal_document_types,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Calculate contract balance if needed
        $contractBalance = null;
        if ($request->filled('contact_value') && $request->filled('contract_value_consumption')) {
            $contractBalance = $request->contact_value - $request->contract_value_consumption;
        }

        // Add contract balance to the data
        $data = $request->all();
        $data['contract_balance'] = $contractBalance;

        // Create the project
        $project = Project::create($data);

        // Attach required document types if selected
        if ($request->has('required_document_types')) {
            $project->requiredDocumentTypes()->attach($request->required_document_types);
        }

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with('legalDocuments.legalDocumentType')->findOrFail($id);
        
        // Group legal documents by type
        $legalDocuments = $project->legalDocuments->groupBy(function($document) {
            return $document->legalDocumentType->name;
        });
        
        return view('panel.projects.show', compact('project', 'legalDocuments'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $documentTypes = LegalDocumentType::all();
        $requiredDocumentTypeIds = $project->requiredDocumentTypes->pluck('id')->toArray();
            $serviceTypes = ServiceType::pluck('name', 'id');

        return view('panel.projects.edit', compact('project', 'documentTypes', 'requiredDocumentTypeIds', 'serviceTypes'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contract_number' => 'nullable|string|max:50',
            'tender_id' => 'nullable|string|max:100',
            'prebid_meeting_date' => 'nullable|date',
            'tender_submit_date' => 'nullable|date',
            'price_open_percentage' => 'nullable|numeric|min:0|max:100',
            'kick_off_meeting_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'client_name' => 'nullable|string|max:255',
            'client_contact' => 'nullable|string|max:255',
            'project_manager' => 'nullable|string|max:255',
            'pipeline_length' => 'nullable|numeric|min:0',
            'pipeline_type' => 'nullable|string|max:100',
            'pipeline_material' => 'nullable|string|max:100',
            'service_type' => 'nullable|in:installation,repair,maintenance,inspection,mixed',
            'status' => 'required|in:pending,active,completed,cancelled',
            'contact_value' => 'nullable|numeric|min:0',
            'contract_value_consumption' => 'nullable|numeric|min:0',
            'amendment_date' => 'nullable|date',
            'amendment_value' => 'nullable|numeric',
            'labour_licence_number' => 'nullable|string|max:100',
            'licence_application_date' => 'nullable|date',
            'required_document_types' => 'nullable|array',
            'required_document_types.*' => 'exists:legal_document_types,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $project = Project::findOrFail($id);
        
        // Calculate contract balance if needed
        if ($request->filled('contact_value') && $request->filled('contract_value_consumption')) {
            $request->merge([
                'contract_balance' => $request->contact_value - $request->contract_value_consumption
            ]);
        }
        
        $project->update($request->all());
        
        // Update required document types
        if ($request->has('required_document_types')) {
            $project->requiredDocumentTypes()->sync($request->required_document_types);
        } else {
            $project->requiredDocumentTypes()->detach();
        }

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        
        if ($project->legalDocuments()->count() > 0) {
            return redirect()->route('projects.index')
                ->with('error', 'Cannot delete project. It has associated legal documents.');
        }
        
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
    
    /**
     * Add legal document to project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addDocument($id)
    {
        $project = Project::findOrFail($id);
        
        return redirect()->route('project-legal-documents.create', ['project_id' => $project->id]);
    }



      /**
     * Get required document types for a project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRequiredDocumentTypes($id)
    {
        try {
            $project = Project::with('requiredDocumentTypes')->findOrFail($id);
            
            $documentTypes = $project->requiredDocumentTypes;
            
            return response()->json([
                'success' => true,
                'documentTypes' => $documentTypes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching document types: ' . $e->getMessage()
            ], 500);
        }
    }
}
