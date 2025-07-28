<?php

namespace App\Http\Controllers;

use App\Models\LegalDocumentType;
use Illuminate\Http\Request;

class LegalDocumentTypeController extends Controller
{
    /**
     * Display a listing of the legal document types.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentTypes = LegalDocumentType::all();
        return view('panel.legal-document-types.index', compact('documentTypes'));
    }

    /**
     * Show the form for creating a new legal document type.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.legal-document-types.create');
    }

    /**
     * Store a newly created legal document type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requires_expiry' => 'boolean'
        ]);

        LegalDocumentType::create($validated);

        return redirect()->route('legal-document-types.index')
            ->with('success', 'Legal document type created successfully.');
    }

    /**
     * Display the specified legal document type.
     *
     * @param  \App\Models\LegalDocumentType  $legalDocumentType
     * @return \Illuminate\Http\Response
     */
    public function show(LegalDocumentType $legalDocumentType)
    {
        return view('panel.legal-document-types.show', compact('legalDocumentType'));
    }

    /**
     * Show the form for editing the specified legal document type.
     *
     * @param  \App\Models\LegalDocumentType  $legalDocumentType
     * @return \Illuminate\Http\Response
     */
    public function edit(LegalDocumentType $legalDocumentType)
    {
        return view('panel.legal-document-types.edit', compact('legalDocumentType'));
    }

    /**
     * Update the specified legal document type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LegalDocumentType  $legalDocumentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LegalDocumentType $legalDocumentType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requires_expiry' => 'boolean'
        ]);

        $legalDocumentType->update($validated);

        return redirect()->route('legal-document-types.index')
            ->with('success', 'Legal document type updated successfully.');
    }

    /**
     * Remove the specified legal document type from storage.
     *
     * @param  \App\Models\LegalDocumentType  $legalDocumentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LegalDocumentType $legalDocumentType)
    {
        // Check if there are any related project legal documents
        if ($legalDocumentType->projectLegalDocuments()->count() > 0) {
            return redirect()->route('legal-document-types.index')
                ->with('error', 'Cannot delete document type. It has related documents.');
        }

        $legalDocumentType->delete();

        return redirect()->route('legal-document-types.index')
            ->with('success', 'Legal document type deleted successfully.');
    }
}
