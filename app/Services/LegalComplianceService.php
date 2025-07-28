<?php

namespace App\Services;

use App\Models\ProjectLegalDocument;
use App\Models\LegalNotification;
use Carbon\Carbon;

class LegalComplianceService
{
    /**
     * Check document expiry and update status for all documents.
     */
    public function checkDocumentExpiry()
    {
        $documents = ProjectLegalDocument::all();
        
        foreach ($documents as $document) {
            $oldStatus = $document->status;
            $document->updateStatus();
            
            // If status changed, generate notifications
            if ($oldStatus !== $document->status) {
                $this->generateNotificationsForDocument($document);
            }
        }
    }
    
    /**
     * Generate notifications for a document based on its status.
     *
     * @param  \App\Models\ProjectLegalDocument  $document
     */
    public function generateNotificationsForDocument(ProjectLegalDocument $document)
    {
        if ($document->status === 'expired') {
            $this->createExpiryNotification($document, 'Document Expired', 
                "The {$document->legalDocumentType->name} for project {$document->project->name} has expired on {$document->validity_date->format('d/m/Y')}.");
        } 
        elseif ($document->status === 'upcoming_expiry') {
            $daysLeft = $document->daysUntilExpiry();
            
            // Create different notifications based on days left
            if ($daysLeft <= 7) {
                $this->createExpiryNotification($document, 'Urgent Document Expiry', 
                    "The {$document->legalDocumentType->name} for project {$document->project->name} will expire in {$daysLeft} days.");
            } 
            elseif ($daysLeft <= 15) {
                $this->createExpiryNotification($document, 'Document Expiring Soon', 
                    "The {$document->legalDocumentType->name} for project {$document->project->name} will expire in {$daysLeft} days.");
            }
            elseif ($daysLeft <= 30) {
                $this->createExpiryNotification($document, 'Document Expiry Notice', 
                    "The {$document->legalDocumentType->name} for project {$document->project->name} will expire in {$daysLeft} days.");
            }
        }
    }
    
    /**
     * Create an expiry notification for a document.
     *
     * @param  \App\Models\ProjectLegalDocument  $document
     * @param  string  $title
     * @param  string  $message
     * @return \App\Models\LegalNotification
     */
    private function createExpiryNotification(ProjectLegalDocument $document, $title, $message)
    {
        // Check if similar notification already exists
        $existingNotification = LegalNotification::where('project_legal_document_id', $document->id)
            ->where('notification_type', 'expiry')
            ->where('is_read', false)
            ->first();
            
        if ($existingNotification) {
            // Update existing notification
            $existingNotification->update([
                'title' => $title,
                'message' => $message,
                'notification_date' => Carbon::now()
            ]);
            
            return $existingNotification;
        }
        
        // For gas pipeline specific document messages
        $pipelineDetails = '';
        if ($document->project->pipeline_type && $document->project->pipeline_material) {
            $pipelineDetails = " for {$document->project->pipeline_type} {$document->project->pipeline_material} pipeline";
        }
        
        // Adjust message based on project type
        $adjustedMessage = str_replace(
            "for project {$document->project->name}",
            "for project {$document->project->name}{$pipelineDetails}",
            $message
        );
        
        // Create new notification
        return LegalNotification::create([
            'project_legal_document_id' => $document->id,
            'notification_type' => 'expiry',
            'title' => $title,
            'message' => $adjustedMessage,
            'is_read' => false,
            'notification_date' => Carbon::now()
        ]);
    }
    
    /**
     * Get legal compliance summary statistics.
     *
     * @return array
     */
    public function getLegalComplianceSummary()
    {
        $stats = [
            'total_documents' => ProjectLegalDocument::count(),
            'valid_documents' => ProjectLegalDocument::where('status', 'valid')->count(),
            'expired_documents' => ProjectLegalDocument::where('status', 'expired')->count(),
            'upcoming_expiry_documents' => ProjectLegalDocument::where('status', 'upcoming_expiry')->count(),
            'pending_documents' => ProjectLegalDocument::where('status', 'pending')->count(),
        ];
        
        // Calculate compliance percentage
        $requiredDocuments = ProjectLegalDocument::where('is_required', true)->count();
        $validRequiredDocuments = ProjectLegalDocument::where('is_required', true)
            ->whereIn('status', ['valid', 'upcoming_expiry'])
            ->count();
            
        $stats['compliance_percentage'] = $requiredDocuments > 0 
            ? round(($validRequiredDocuments / $requiredDocuments) * 100) 
            : 0;
            
        return $stats;
    }
}