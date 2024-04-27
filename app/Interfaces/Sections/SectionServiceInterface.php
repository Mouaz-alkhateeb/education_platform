<?php

namespace App\Interfaces\Sections;


interface SectionServiceInterface
{
    public function create_section($data);
    public function update_section($data);
    public function delete_section(int $id);
}
