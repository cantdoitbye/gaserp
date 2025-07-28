<?php

namespace App\Http\Controllers;

use App\Models\ProjectLegalDocument;
use App\Models\LegalDocumentType;
use App\Models\Project;
use App\Services\LegalComplianceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectLegalDocumentController extends Controller
{
    protected $legalComplianceService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\LegalComplianceService  $legalComplianceService
     * @return void
     */
    public function __construct(LegalComplianceService $legalComplianceService)
    {
        $this->legalComplianceService = $legalComplianceService;
    }

    /**
     * Display a listing of the project legal documents.
     *
     * @return \Illuminate\Http\Response
     */
  public function index(Request $request)
{
    $query = ProjectLegalDocument::with(['legalDocumentType', 'project']);

    // Apply filters if provided
    if ($request->has('project_id') && $request->project_id) {
        $query->where('project_id', $request->project_id);
    }

    if ($request->has('document_type_id') && $request->document_type_id) {
        $query->where('legal_document_type_id', $request->document_type_id);
    }

    if ($request->has('status') && $request->status) {
        $query->where('status', $request->status);
    }

    // Update document statuses if needed to ensure accurate days counting
    $documents = $query->get();
    foreach ($documents as $document) {
        $document->updateStatus();
    }
    
    // Get sort parameters
    $sortField = $request->input('sort', 'created_at');
    $sortDirection = $request->input('direction', 'desc');
    
    // Special handling for days_until_expiry since it's a calculated field
    $isSortingByDaysUntilExpiry = ($sortField === 'days_until_expiry');
    
    // If not sorting by days_until_expiry, use database sorting
    if (!$isSortingByDaysUntilExpiry) {
        // Only allow sorting by certain database columns
        $allowedSortFields = ['created_at', 'issue_date', 'validity_date', 'status'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at';
        }
        
        // Re-run the query with sorting
        $query = ProjectLegalDocument::with(['legalDocumentType', 'project']);
        
        // Re-apply filters
        if ($request->has('project_id') && $request->project_id) {
            $query->where('project_id', $request->project_id);
        }
    
        if ($request->has('document_type_id') && $request->document_type_id) {
            $query->where('legal_document_type_id', $request->document_type_id);
        }
    
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Apply database sorting
        $documents = $query->orderBy($sortField, $sortDirection)->paginate(10);
    }
    else {
        // For days_until_expiry, we need to sort in PHP after retrieving all data
        // Re-run the query without sorting
        $query = ProjectLegalDocument::with(['legalDocumentType', 'project']);
        
        // Re-apply filters
        if ($request->has('project_id') && $request->project_id) {
            $query->where('project_id', $request->project_id);
        }
    
        if ($request->has('document_type_id') && $request->document_type_id) {
            $query->where('legal_document_type_id', $request->document_type_id);
        }
    
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Get all matching documents
        $allDocuments = $query->get();
        
        // Calculate days until expiry for each document
        foreach ($allDocuments as $document) {
            $document->days_until_expiry = $document->daysUntilExpiry() ?? PHP_INT_MAX; // Use max value for null
        }
        
        // Sort the collection
        if ($sortDirection === 'asc') {
            $allDocuments = $allDocuments->sortBy('days_until_expiry');
        } else {
            $allDocuments = $allDocuments->sortByDesc('days_until_expiry');
        }
        
        // Manually paginate the collection
        $page = $request->input('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        
        $paginatedData = $allDocuments->slice($offset, $perPage);
        $documents = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedData, 
            $allDocuments->count(), 
            $perPage, 
            $page, 
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
    
    // Calculate days until expiry for display
    foreach ($documents as $document) {
        if (!isset($document->days_until_expiry)) {
            $document->days_until_expiry = $document->daysUntilExpiry();
        }
    }
    
    $projects = Project::pluck('name', 'id');
    $documentTypes = LegalDocumentType::pluck('name', 'id');

    return view('panel.project-legal-documents.index', compact('documents', 'projects', 'documentTypes', 'sortField', 'sortDirection'));
}

    /**
     * Show the form for creating a new project legal document.
     *
     * @return \Illuminate\Http\Response
     */
  public function create(Request $request)
{
    // Check if project_id is provided
    $projects = Project::pluck('name', 'id');
    
    // Initialize variables
    $project = null;
    $documentTypes = LegalDocumentType::all();
    $preSelectedProjectId = null;
    
    // Check if project_id is provided in URL or request
    if ($request->has('project_id') || $request->query('project_id')) {
        $projectId = $request->input('project_id') ?: $request->query('project_id');
        
        // Find the project
        $project = Project::with('requiredDocumentTypes')->find($projectId);
        
        if ($project) {
            $preSelectedProjectId = $project->id;
            
            // If required_only flag is true, only show document types required for this project
            // if ($request->has('required_only') && $request->required_only) {
                if ($project->requiredDocumentTypes->count() > 0) {
                    $documentTypes = $project->requiredDocumentTypes;
                }
            // }
        }
    }
        return view('panel.project-legal-documents.create', compact('projects', 'documentTypes', 'project', 'preSelectedProjectId'));

}

    /**
     * Store a newly created project legal document in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    $validated = $request->validate([
       'project_id' => 'required|exists:projects,id',
        'legal_document_type_id' => 'required|exists:legal_document_types,id',
        'license_number' => 'nullable|string|max:255',
        'is_required' => 'boolean',
        'application_date' => 'nullable|date',
        'issue_date' => 'nullable|date',
        'validity_date' => 'nullable|date|after_or_equal:issue_date',
        'reapply_date' => 'nullable|date',
        'reapplication_status' => 'nullable|string|in:not_required,to_be_applied,in_process,completed',
        'document_file' => 'nullable|file|max:10240',
    ]);

    // Verify this document type is required for the project
    $project = Project::findOrFail($request->project_id);
    if (!$project->isDocumentTypeRequired($request->legal_document_type_id)) {
        // If not currently required, add it to the required types
        $project->requiredDocumentTypes()->attach($request->legal_document_type_id);
    }

    // Handle file upload if provided
    if ($request->hasFile('document_file')) {
        $path = $request->file('document_file')->store('legal-documents');
        $validated['document_file'] = $path;
    }

    // Set initial status
    $validated['status'] = 'pending';

    $document = ProjectLegalDocument::create($validated);
    
    // Update document status
    $document->updateStatus();
    
    // Generate notifications if needed
    $this->legalComplianceService->generateNotificationsForDocument($document);

    return redirect()->route('project-legal-documents.index')
        ->with('success', 'Project legal document created successfully.');
}

    /**
     * Display the specified project legal document.
     *
     * @param  \App\Models\ProjectLegalDocument  $projectLegalDocument
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectLegalDocument $projectLegalDocument)
    {
        $projectLegalDocument->load(['legalDocumentType', 'project', 'notifications']);
        
        return view('panel.project-legal-documents.show', compact('projectLegalDocument'));
    }

    /**
     * Show the form for editing the specified project legal document.
     *
     * @param  \App\Models\ProjectLegalDocument  $projectLegalDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectLegalDocument $projectLegalDocument)
    {
        $projects = Project::pluck('name', 'id');
        $documentTypes = LegalDocumentType::pluck('name', 'id');
        
        return view('panel.project-legal-documents.edit', compact('projectLegalDocument', 'projects', 'documentTypes'));
    }

    /**
     * Update the specified project legal document in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectLegalDocument  $projectLegalDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectLegalDocument $projectLegalDocument)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'legal_document_type_id' => 'required|exists:legal_document_types,id',
            'is_required' => 'boolean',
            'issue_date' => 'nullable|date',
            'validity_date' => 'nullable|date|after_or_equal:issue_date',
            'document_file' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Handle file upload if provided
        if ($request->hasFile('document_file')) {
            // Delete old file if exists
            if ($projectLegalDocument->document_file) {
                Storage::delete($projectLegalDocument->document_file);
            }
            
            $path = $request->file('document_file')->store('legal-documents');
            $validated['document_file'] = $path;
        }

        $projectLegalDocument->update($validated);
        
        // Update document status
        $projectLegalDocument->updateStatus();
        
        // Generate notifications if needed
        $this->legalComplianceService->generateNotificationsForDocument($projectLegalDocument);

        return redirect()->route('project-legal-documents.index')
            ->with('success', 'Project legal document updated successfully.');
    }

    /**
     * Remove the specified project legal document from storage.
     *
     * @param  \App\Models\ProjectLegalDocument  $projectLegalDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectLegalDocument $projectLegalDocument)
    {
        // Delete file if exists
        if ($projectLegalDocument->document_file) {
            Storage::delete($projectLegalDocument->document_file);
        }
        
        // Delete related notifications
        $projectLegalDocument->notifications()->delete();
        
        // Delete the document
        $projectLegalDocument->delete();

        return redirect()->route('project-legal-documents.index')
            ->with('success', 'Project legal document deleted successfully.');
    }

    /**
     * Upload document file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'document_file' => 'required|file|max:10240', // 10MB max
        ]);

        $document = ProjectLegalDocument::findOrFail($id);
        
        // Delete old file if exists
        if ($document->document_file) {
            Storage::delete($document->document_file);
        }
        
        $path = $request->file('document_file')->store('legal-documents');
        $document->update(['document_file' => $path]);

        return redirect()->route('project-legal-documents.show', $document)
            ->with('success', 'Document file uploaded successfully.');
    }

    /**
     * Download document file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadDocument($id)
    {
        $document = ProjectLegalDocument::findOrFail($id);
        
        if (!$document->document_file) {
            return redirect()->back()->with('error', 'No document file available.');
        }
        
        return Storage::download($document->document_file);
    }
}
