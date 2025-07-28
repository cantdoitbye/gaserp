<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PngRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
 public function rules()
    {
        $rules = [
            // Basic Information - Required fields matching Excel layout
            // 'name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',

            // Basic Information - Optional fields
            'agreement_date' => 'nullable|date',
            'customer_no' => 'nullable|string|max:255',
            'service_order_no' => 'nullable|string|max:255',
            'application_no' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'area' => 'nullable|string',
            'scheme' => 'nullable|in:bungalow,tapping,row_house,floor_trf',
            // 'geyser_point' => 'nullable|integer|min:0',
            // 'kitchen' => 'nullable|integer|min:0',
            'sla_days' => 'nullable|integer|min:0|max:9999',
            
            // Technical Information fields
            'connections_status' => 'nullable|in:workable,not_workable,plb_done,pdt_pending,gc_pending,mmt_pending,conv_pending,comm,bill_pending,bill_received',
            'plumber_name' => 'nullable|string|max:255',
            'plumbing_date' => 'nullable|date',
            'pdt_date' => 'nullable|date',
            'pdt_witness_by' => 'nullable|string|max:255',
            'ground_connections_date' => 'nullable|date',
            'ground_connections_witness_by' => 'nullable|string|max:255',
            'isolation_name' => 'nullable|string|max:255',
            'mmt_date' => 'nullable|date',
            'mmt_witness_by' => 'nullable|string|max:255',
            'conversion_technician_name' => 'nullable|string|max:255',
            'conversion_date' => 'nullable|date',
            'conversion_status' => 'nullable|in:conv_done,comm,pending',
            'report_submission_date' => 'nullable|date',
            'meter_number' => 'nullable|string|max:255',
            'ra_bill_no' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            
            // Dynamic Measurements - Make optional for now to allow testing
            'png_measurement_type_id' => 'nullable|exists:png_measurement_types,id',
            'measurements' => 'nullable|array',
            'measurements.*' => 'nullable',
            
            // File uploads
            'scan_copy' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'autocad_drawing' => 'nullable|file|mimes:dwg,dxf,pdf|max:10240',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            
            // New file types
            'job_cards.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'autocad_dwg.*' => 'nullable|file|mimes:dwg,dxf,pdf|max:10240',
            'site_visit_reports.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'other_documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ];

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'png_measurement_type_id.required' => 'Measurement type is required.',
            'png_measurement_type_id.exists' => 'Selected measurement type is invalid.',
            'area.in' => 'Please select a valid area.',
            'scheme.in' => 'Please select a valid scheme.',
            'connections_status.in' => 'Please select a valid connections status.',
            'conversion_status.in' => 'Please select a valid conversion status.',
            'geyser.integer' => 'Geyser points must be a valid number.',
            'kitchen.integer' => 'Kitchen points must be a valid number.',
            'sla_days.integer' => 'SLA Days must be a valid number.',
            'scan_copy.mimes' => 'Scan copy must be a PDF, JPG, JPEG, or PNG file.',
            'scan_copy.max' => 'Scan copy file size cannot exceed 5MB.',
            'autocad_drawing.mimes' => 'AutoCAD drawing must be a DWG, DXF, or PDF file.',
            'autocad_drawing.max' => 'AutoCAD drawing file size cannot exceed 10MB.',
            'certificate.mimes' => 'Certificate must be a PDF, JPG, JPEG, or PNG file.',
            'certificate.max' => 'Certificate file size cannot exceed 5MB.',
            'job_cards.*.mimes' => 'Job card files must be PDF, JPG, JPEG, PNG, DOC, or DOCX.',
            'job_cards.*.max' => 'Each job card file size cannot exceed 5MB.',
            'autocad_dwg.*.mimes' => 'AutoCAD files must be DWG, DXF, or PDF.',
            'autocad_dwg.*.max' => 'Each AutoCAD file size cannot exceed 10MB.',
            'site_visit_reports.*.mimes' => 'Site visit report files must be PDF, JPG, JPEG, PNG, DOC, or DOCX.',
            'site_visit_reports.*.max' => 'Each site visit report file size cannot exceed 5MB.',
            'other_documents.*.mimes' => 'Other document files must be PDF, JPG, JPEG, PNG, DOC, or DOCX.',
            'other_documents.*.max' => 'Each other document file size cannot exceed 5MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Convert measurements array to proper format for storage
        if ($this->has('measurements') && is_array($this->measurements)) {
            $this->merge([
                'measurements_data' => $this->measurements
            ]);
        }
    }

    /**
     * Get validated data with proper formatting
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        
        // Format measurements data for storage
        if (isset($validated['measurements'])) {
            $validated['measurements_data'] = $validated['measurements'];
            unset($validated['measurements']);
        }
        
        return $validated;
    }
}
