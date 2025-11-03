<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'video_id' => 'required|exists:videos,id',
            'content' => 'required|string|max:50000',
            'pdf_path' => 'nullable|file|mimes:pdf|max:20480',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'video_id.required' => 'Please select a video for this note.',
            'video_id.exists' => 'The selected video does not exist.',
            'content.required' => 'Note content is required.',
            'content.max' => 'Note content cannot exceed 50,000 characters.',
            'pdf_path.mimes' => 'The PDF must be a valid PDF file.',
            'pdf_path.max' => 'The PDF file cannot exceed 20 MB.',
        ];
    }
}
