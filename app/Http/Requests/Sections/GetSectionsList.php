<?php

namespace App\Http\Requests\Sections;

use App\Filters\Sections\SectionFilter;
use Illuminate\Foundation\Http\FormRequest;

class GetSectionsList extends FormRequest
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
        $sectionFilter = new SectionFilter();

        if ($this->filled('name')) {
            $sectionFilter->setName($this->input('name'));
        }
        if ($this->filled('order_by')) {
            $sectionFilter->setOrderBy($this->input('order_by'));
        }

        if ($this->filled('order')) {
            $sectionFilter->setOrder($this->input('order'));
        }

        if ($this->filled('per_page')) {
            $sectionFilter->setPerPage($this->input('per_page'));
        }
        return $sectionFilter;
    }
}
