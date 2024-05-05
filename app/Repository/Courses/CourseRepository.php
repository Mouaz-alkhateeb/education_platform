<?php

namespace App\Repository\Courses;

use App\Filters\Courses\CourseFilter;
use App\Models\Course;
use App\Repository\BaseRepositoryImplementation;
use Illuminate\Support\Facades\DB;

class CourseRepository extends BaseRepositoryImplementation
{
    public function getFilterItems($filter)
    {

        $records = Course::query();
        if ($filter instanceof CourseFilter) {
            $records->when(isset($filter->name), function ($records) use ($filter) {
                $records->where('name', 'LIKE', '%' . $filter->getName() . '%');
            });
            return $records->get();
        }

        return $records->get();
    }

    public function model()
    {
        return Course::class;
    }

    public function create_course($data)
    {
        DB::beginTransaction();
        try {
            $course = new Course();
            $course->name = $data['name'];
            $course->section_id = $data['section_id'];
            $course->course_owner = $data['course_owner'];
            $course->price = $data['price'];
            $course->save();

            DB::commit();
            return $course;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }
    public function update_course($data)
    {
        DB::beginTransaction();
        try {

            $course = Course::where('id', $data['course_id'])->first();
            if ($course && isset($data['name'])) {
                $course->update([
                    'name' => $data['name'],
                ]);
            }
            if ($course && isset($data['price'])) {
                $course->update([
                    'price' => $data['price'],
                ]);
            }
            DB::commit();
            return $course;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }
    public function delete_Course(int $id)
    {
            $course = Course::where('id', $id)->first();

            if ($course) {
                $course->delete();
                return response()->json(['message' => 'Course Delete Successfully'], 200);
            } else {
                return response()->json(['message' => 'Course Not Found'], 404);
            }
    }
}