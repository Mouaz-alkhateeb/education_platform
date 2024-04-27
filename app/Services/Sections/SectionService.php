<?php

namespace App\Services\Sections;

use App\Filters\Sections\SectionFilter;
use App\Interfaces\Sections\SectionServiceInterface;
use App\Repository\Sections\SectionRepository;

class SectionService implements SectionServiceInterface
{
    public function __construct(private SectionRepository $sectionRepository)
    {
    }
    public function create_section($data)
    {
        return $this->sectionRepository->create_section($data);
    }
    public function update_section($data)
    {
        return $this->sectionRepository->update_section($data);
    }
    public function delete_section(int $id)
    {
        return $this->sectionRepository->delete_section($id);
    }
    public function list_of_sections(SectionFilter $sectionFilter = null)
    {
        if ($sectionFilter != null)
            return $this->sectionRepository->getFilterItems($sectionFilter);
        else
            return $this->sectionRepository->get();
    }
}
