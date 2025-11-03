<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
        $courseId = $this->route('course')?->id;

        return [
            'level_id' => 'required|exists:levels,id',
            'title' => 'required|string|max:255|unique:courses,title,' . $courseId,
            'description' => 'nullable|string|max:1000',
            'thumbnail_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB max
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'level_id.required' => 'Please select a level for this course',
            'level_id.exists' => 'The selected level does not exist',
            'title.required' => 'Course title is required',
            'title.unique' => 'A course with this title already exists',
            'thumbnail_path.image' => 'The thumbnail must be an image',
            'thumbnail_path.max' => 'The thumbnail size must not exceed 5MB',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? true : false,
        ]);
    }
}
