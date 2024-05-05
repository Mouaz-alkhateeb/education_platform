<?php

namespace App\Interfaces\Courses;


interface CourseServiceInterface
{
    public function create_course($data);
    public function update_course($data);
    public function delete_course(int $id);
}
