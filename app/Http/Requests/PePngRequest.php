<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PePngRequest extends FormRequest
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
            'job_order_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pe_pngs')->ignore($this->pe_png),
            ],
            'category' => 'required|in:domestic,commercial,riser,gc,conversion',
            'plumbing_date' => 'required|date',
            'plumber_id' => 'required|exists:plumbers,id',
            'gc_date' => 'nullable|date',
            'mmt_date' => 'nullable|date',
            'site_visits' => 'nullable|array',
            'remarks' => 'nullable|string',
            'bill_ra_no' => 'nullable|string|max:255',
            'plb_bill_status' => 'nullable|in:pending,processed,paid,locked',
            'scan_copy' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sla_days' => 'nullable|integer|min:0',
            'pe_dpr' => 'nullable|string',
            'autocad_drawing' => 'nullable|file|mimes:dwg,dxf,pdf|max:5120',
            'consumption_details' => 'nullable|array',
            'free_issue_details' => 'nullable|array',
        ];

        return $rules;
    }
}
