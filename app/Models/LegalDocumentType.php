<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalDocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'requires_expiry'
    ];

    protected $casts = [
        'requires_expiry' => 'boolean',
    ];

    /**
     * Get the project legal documents for this document type.
     */
    public function projectLegalDocuments()
    {
        return $this->hasMany(ProjectLegalDocument::class);
    }

     /**
     * Get the projects that require this document type.
     */
    public function requiredByProjects()
    {
        return $this->belongsToMany(Project::class, 'project_required_document_types')
            ->withTimestamps();
    }
}
