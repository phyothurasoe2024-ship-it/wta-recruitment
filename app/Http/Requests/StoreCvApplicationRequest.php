<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCvApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'min:2', 'max:120'],
            'nrc'             => ['required', 'string', 'min:4', 'max:60', 'unique:cv_applications,nrc'],
            'address'         => ['required', 'string', 'min:5', 'max:1000'],
            'email'           => ['required', 'string', 'email:rfc', 'max:160'],
            'phone'           => ['required', 'string', 'regex:/^[0-9+\-\s()]{6,40}$/'],
            'photo'           => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'nrc_file'        => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'work_experience' => ['nullable', 'string', 'max:5000'],
            'education'       => ['nullable', 'string', 'max:5000'],
            'why_join_wta'    => ['required', 'string', 'min:20', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Please enter your full name.',
            'nrc.required'         => 'NRC number is required.',
            'nrc.unique'           => 'This NRC has already been used to submit an application.',
            'address.required'     => 'Address is required.',
            'email.required'       => 'Email is required.',
            'email.email'          => 'Please provide a valid email address.',
            'phone.required'       => 'Phone number is required.',
            'phone.regex'          => 'Phone number may only contain digits, spaces, + ( ) and -.',
            'photo.mimes'          => 'Photo must be a JPG, JPEG, or PNG image.',
            'photo.max'            => 'Photo must not be larger than 2 MB.',
            'nrc_file.mimes'       => 'NRC attachment must be a JPG, JPEG, PNG, or PDF file.',
            'nrc_file.max'         => 'NRC attachment must not be larger than 4 MB.',
            'why_join_wta.required'=> 'Please tell us why you want to join WTA.',
            'why_join_wta.min'     => 'Please write at least 20 characters about why you want to join WTA.',
        ];
    }

    public function attributes(): array
    {
        return [
            'why_join_wta' => 'reason for joining',
            'nrc'          => 'NRC',
            'nrc_file'     => 'NRC attachment',
        ];
    }
}
