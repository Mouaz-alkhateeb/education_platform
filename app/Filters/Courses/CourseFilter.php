<?php

namespace App\Filters\Courses;

use App\Filters\OthersBaseFilter;

class CourseFilter extends OthersBaseFilter
{
    public ?string $name = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}