<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255|unique:videos,title',
            'description' => 'nullable|string|max:1000',
            'video_path' => 'required|file|mimes:mp4,mov,avi,wmv,webm|max:2097152', // 2GB max
            'duration' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'The selected course does not exist.',
            'title.required' => 'Video title is required.',
            'title.max' => 'Video title must not exceed 255 characters.',
            'title.unique' => 'A video with this title already exists.',
            'description.max' => 'Description must not exceed 1000 characters.',
            'video_path.required' => 'Please select a video file to upload.',
            'video_path.file' => 'The video must be a file.',
            'video_path.mimes' => 'The video must be in one of these formats: mp4, mov, avi, wmv, webm.',
            'video_path.max' => 'The video file size must not exceed 2GB.',
            'duration.integer' => 'Duration must be a valid number.',
            'duration.min' => 'Duration must be 0 or greater.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? 1 : 0,
        ]);
    }
}
