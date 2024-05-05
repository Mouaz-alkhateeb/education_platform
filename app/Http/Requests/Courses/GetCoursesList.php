<?php

namespace App\Http\Requests\Courses;

use App\Filters\Courses\CourseFilter;
use Illuminate\Foundation\Http\FormRequest;

class GetCoursesList extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
    public function generateFilter()
    {
        $reservationFilter = new CourseFilter();

        if ($this->filled('name')) {
            $reservationFilter->setName($this->input('name'));
        }

        if ($this->filled('order_by')) {
            $reservationFilter->setOrderBy($this->input('order_by'));
        }

        if ($this->filled('order')) {
            $reservationFilter->setOrder($this->input('order'));
        }

        if ($this->filled('per_page')) {
            $reservationFilter->setPerPage($this->input('per_page'));
        }
        return $reservationFilter;
    }
}
