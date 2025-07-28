<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlumberRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ];

          // If this is an update request, exclude the current plumber from unique checks
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $plumberId = $this->route('plumber')->id;
            $rules['email'] = "nullable|email|max:255|unique:plumbers,email,{$plumberId}";
        }

        return $rules;
    }
}
