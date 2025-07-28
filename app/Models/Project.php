<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contract_number',
        'release_order_date',
        'tender_id',
        'prebid_meeting_date',
        'tender_submit_date',
        'price_open_percentage',
        'kick_off_meeting_date',
        'location',
        'description',
        'start_date',
        'end_date',
        'client_name',
        'client_contact',
        'project_manager',
        'pipeline_length',
        'pipeline_type',
        'pipeline_material',
         'service_type_id',
        // 'service_type',
        'status',
        'contact_value',
        'contract_value_consumption',
        'contract_balance',
        'amendment_date',
        'amendment_value',
        'labour_licence_number',
        'licence_application_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'pipeline_length' => 'float',
           'price_open_percentage' => 'float',
        'contact_value' => 'float',
        'contract_value_consumption' => 'float',
        'contract_balance' => 'float',
        'amendment_value' => 'float',
        'prebid_meeting_date' => 'date',
        'tender_submit_date' => 'date', 
        'kick_off_meeting_date' => 'date',
        'amendment_date' => 'date',
        'licence_application_date' => 'date',
    ];

    /**
     * Get the legal documents for the project.
     */
    public function legalDocuments()
    {
        return $this->hasMany(ProjectLegalDocument::class);
    }




    /**
     * Get the required document types for this project.
     */
    public function requiredDocumentTypes()
    {
        return $this->belongsToMany(LegalDocumentType::class, 'project_required_document_types')
            ->withTimestamps();
    }
    
    /**
     * Check if a specific document type is required for this project.
     */
    public function isDocumentTypeRequired($documentTypeId)
    {
        return $this->requiredDocumentTypes()->where('legal_document_type_id', $documentTypeId)->exists();
    }
    
    /**
     * Calculate contract balance based on consumption.
     */
    public function calculateContractBalance()
    {
        if ($this->contact_value && $this->contract_value_consumption) {
            $this->contract_balance = $this->contact_value - $this->contract_value_consumption;
            $this->save();
        }
        
        return $this->contract_balance;
    }



      /**
     * Get the service type associated with the project.
     */
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }


       /**
     * Get the service type name for display
     */
    public function getServiceTypeNameAttribute()
    {
        return $this->serviceType ? $this->serviceType->name : null;
    }
}
