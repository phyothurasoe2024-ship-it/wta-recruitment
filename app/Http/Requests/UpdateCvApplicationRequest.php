<?php

namespace App\Http\Requests;

use App\Models\CvApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCvApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'status'      => ['required', Rule::in(CvApplication::STATUSES)],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Please pick a status.',
            'status.in'       => 'The selected status is invalid.',
        ];
    }
}
