<?php

namespace App\Filters\Sections;

use App\Filters\OthersBaseFilter;

class SectionFilter extends OthersBaseFilter
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
