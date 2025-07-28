<?php

namespace App\Http\Controllers;

use App\Models\ProjectLegalDocument;
use App\Models\LegalDocumentType;
use App\Models\Project;
use App\Models\LegalNotification;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Carbon\Carbon;
class LegalDashboardController extends Controller
{
  /**
     * Display the legal dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $projectId
     * @return \Illuminate\Http\Response
     */

      public function indexdesk(Request $request)
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

        return view('panel.legal-desk.indexdesk', compact(
            'projects', 
            'locations', 
            'clients', 
            'serviceTypes',
            'tenderIds',
            'contractNumbers'
        ));
    }
    public function index(Request $request, $projectId = null)
    {
        // Get all document types for the summary table headers
        $documentTypes = LegalDocumentType::all();
        
        // Get all locations/projects for the filter dropdown
        $locations = Project::distinct('location')->pluck('location');
        $contracts = Project::pluck('contract_number', 'id');
        
        $project = null;
        $summaryData = [];
        $isFiltered = false;
        
        // If project ID is provided, get the specific project
        if ($projectId) {
            $project = Project::findOrFail($projectId);
            // Pre-select the project's contract in the filter
            $request->merge(['contract_id' => $projectId]);
            
            // Get project-specific summary data
            $filters = ['contract_id' => $projectId];
            $summaryData = $this->getSummaryData($filters);
            $isFiltered = true;
        }
        // Check if any filters are applied via GET request
        elseif ($request->has('contract_id') && $request->contract_id ||
                $request->has('location') && $request->location ||
                $request->has('from_date') && $request->from_date ||
                $request->has('to_date') && $request->to_date) {
            
            $filters = $request->only(['location', 'from_date', 'to_date', 'contract_id']);
        //    dd($filters);
            $summaryData = $this->getSummaryData($filters);
            // dd($summaryData);
            $isFiltered = true;
            
            // If contract is selected, get the project
            if ($request->has('contract_id') && $request->contract_id) {
                $project = Project::find($request->contract_id);
                            $projectId = $request->has('contract_id');

            }

        }
        
        // Get unread notifications (filtered by project if specified)
        $notificationsQuery = LegalNotification::unread()
            ->with('projectLegalDocument.legalDocumentType');
            
        if ($projectId) {
            $notificationsQuery->whereHas('projectLegalDocument', function($q) use ($projectId) {
                $q->where('project_id', $projectId);
            });
        } elseif ($request->has('contract_id') && $request->contract_id) {
            $notificationsQuery->whereHas('projectLegalDocument', function($q) use ($request) {
                $q->where('project_id', $request->contract_id);
            });
        }
        
        $unreadNotifications = $notificationsQuery->latest()->take(4)->get();
        
        // Get notification counts (filtered by project if specified)
        $unreadCountQuery = LegalNotification::unread();
        $readCountQuery = LegalNotification::read();
        
        if ($projectId) {
            $unreadCountQuery->whereHas('projectLegalDocument', function($q) use ($projectId) {
                $q->where('project_id', $projectId);
            });
            
            $readCountQuery->whereHas('projectLegalDocument', function($q) use ($projectId) {
                $q->where('project_id', $projectId);
            });
        } elseif ($request->has('contract_id') && $request->contract_id) {
            $unreadCountQuery->whereHas('projectLegalDocument', function($q) use ($request) {
                $q->where('project_id', $request->contract_id);
            });
            
            $readCountQuery->whereHas('projectLegalDocument', function($q) use ($request) {
                $q->where('project_id', $request->contract_id);
            });
        }
        
        $unreadCount = $unreadCountQuery->count();
        $readCount = $readCountQuery->count();

        // dd($summaryData);
        
        return view('panel.legal-desk.index', compact(
            'documentTypes', 
            'locations', 
            'contracts', 
            'summaryData', 
            'unreadNotifications',
            'unreadCount',
            'readCount',
            'project',
            'projectId',
            'isFiltered'
        ));
    }
    
    /**
     * Filter the dashboard data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $validated = $request->validate([
            'location' => 'nullable|string',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'contract_id' => 'nullable|exists:projects,id',
        ]);
        
        // Check if any filters are applied
        $hasFilters = false;
        foreach ($validated as $filter) {
            if (!empty($filter)) {
                $hasFilters = true;
                break;
            }
        }
        
        // If no filters, return empty data
        if (!$hasFilters) {
            return response()->json([
                'success' => true,
                'summaryData' => [],
                'message' => 'Please select at least one filter to view data.'
            ]);
        }
        
        // Process filters and get filtered summary data
        // $summaryData = $this->getSummaryData($validated);

          // Process filters and get filtered summary data
        $summaryData = $this->getSummaryData($validated);
        
        // Redirect back with the parameters in the URL
        return redirect()->route('legal-desk.index', $request->all());
        
        // Get project info if contract_id is provided
        // $project = null;
        // if (!empty($validated['contract_id'])) {
        //     $project = Project::find($validated['contract_id']);
        // }
        
        // return response()->json([
        //     'success' => true,
        //     'summaryData' => $summaryData,
        //     'project' => $project ? [
        //         'id' => $project->id,
        //         'name' => $project->name,
        //         'contract_number' => $project->contract_number,
        //         'location' => $project->location,
        //         'status' => $project->status
        //     ] : null
        // ]);
    }
    
    /**
     * Get summary data for the dashboard.
     *
     * @param  array  $filters
     * @return array
     */
    private function getSummaryData(array $filters = [])
    {
        // Check if there are any active filters
        $hasFilters = false;
        foreach ($filters as $filter) {
            if (!empty($filter)) {
                $hasFilters = true;
                break;
            }
        }
        
        // If no filters are active, return empty array
        if (!$hasFilters) {
            return [];
        }
        
        // Start with base query
        $query = ProjectLegalDocument::with(['legalDocumentType', 'project']);
        
        // Apply filters if provided
        if (!empty($filters['location'])) {
            $query->whereHas('project', function($q) use ($filters) {
                $q->where('location', $filters['location']);
            });
        }
        
        if (!empty($filters['from_date'])) {
            $query->where('issue_date', '>=', $filters['from_date']);
        }
        
        if (!empty($filters['to_date'])) {
            $query->where('issue_date', '<=', $filters['to_date']);
        }
        
        if (!empty($filters['contract_id'])) {
            $query->where('project_id', $filters['contract_id']);
        }
        
        // Get all documents
         $documents = $query->get();
        
        // Group by document type
        $documentTypes = LegalDocumentType::all();
        
        $summaryData = [];
        foreach ($documentTypes as $type) {
            $typeDocuments = $documents->where('legal_document_type_id', $type->id);
            
            if ($typeDocuments->count() > 0) {
                // Get the most recent document of this type
                $latestDocument = $typeDocuments->sortByDesc('issue_date')->first();
                
                $summaryData[$type->id] = [
                    'name' => $type->name,
                    'application_date' => $latestDocument->application_date ? $latestDocument->application_date->format('d/m/Y') : '-',
                    'issue_date' => $latestDocument->issue_date ? $latestDocument->issue_date->format('d/m/Y') : '-',
                    'validity_date' => $latestDocument->validity_date ? $latestDocument->validity_date->format('d/m/Y') : '-',
                    'status' => $latestDocument->status,
                    'days_until_expiry' => $latestDocument->daysUntilExpiry(),
                    'project_name' => $latestDocument->project->name,
                    'contract_number' => $latestDocument->project->contract_number
                ];
            }
        }
        
        return $summaryData;
    }
}
