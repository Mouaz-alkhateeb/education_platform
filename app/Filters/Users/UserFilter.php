<?php

namespace App\Filter\Users;

use App\Filter\OthersBaseFilter;

class UserFilter extends OthersBaseFilter
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