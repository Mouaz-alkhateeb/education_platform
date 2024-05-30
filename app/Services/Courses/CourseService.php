<?php

namespace App\Services\Courses;

use App\Filters\Courses\CourseFilter;
use App\Interfaces\Courses\CourseServiceInterface;
use App\Repository\Courses\CourseRepository;

class CourseService implements CourseServiceInterface
{
    public function __construct(private CourseRepository $courseRepository)
    {
    }
    public function create_course($data)
    {
        return $this->courseRepository->create_course($data);
    }
    public function update_course($data)
    {
        return $this->courseRepository->update_course($data);
    }
    public function update_status($id)
    {
        return $this->courseRepository->update_status($id);
    }
    public function delete_Course(int $id)
    {
        return $this->courseRepository->delete_Course($id);
    }
    public function list_of_courses(CourseFilter $courseFilter = null)
    {
        if ($courseFilter != null)
            return $this->courseRepository->getFilterItems($courseFilter);
        else
            return $this->courseRepository->get();
    }
    public function show(int $id)
    {
        return $this->courseRepository->getById($id)->load('reviews');
    }
}
