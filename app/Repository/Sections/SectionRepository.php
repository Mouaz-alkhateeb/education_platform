<?php

namespace App\Repository\Sections;

use App\Filters\Sections\SectionFilter;
use App\Http\Trait\UploadImage;
use App\Models\Section;
use App\Repository\BaseRepositoryImplementation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class SectionRepository extends BaseRepositoryImplementation
{
    use UploadImage;
    public function getFilterItems($filter)
    {

        $records = Section::query();
        if ($filter instanceof SectionFilter) {
            $records->when(isset($filter->name), function ($records) use ($filter) {
                $records->where('name', 'LIKE', '%' . $filter->getName() . '%');
            });
            return $records->get();
        }

        return $records->get();
    }

    public function model()
    {
        return Section::class;
    }

    public function create_section($data)
    {
        DB::beginTransaction();
        try {
            $section = new Section();
            $section->name = $data['name'];
            if ($section && isset($data['parent'])) {
                $section->parent = $data['parent'];
            }
            if (Arr::has($data, 'image')) {
                $file = Arr::get($data, 'image');
                $file_name = $this->uploadSectionAttachment($file);
                $section->image = $file_name;
            }
            $section->save();
            DB::commit();
            return $section;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }
    public function update_section($data)
    {
        DB::beginTransaction();
        try {

            $section = Section::where('id', $data['section_id'])->first();
            if ($section && isset($data['name'])) {
                $section->update([
                    'name' => $data['name'],
                ]);
            }
            if (Arr::has($data, 'image')) {
                $file = Arr::get($data, 'image');
                $file_name = $this->uploadSectionAttachment($file);
                $section->image = $file_name;
            }
            DB::commit();
            return $section;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }
    public function delete_section(int $id)
    {
        $section = Section::where('id', $id)->first();

        if ($section) {
            $section->delete();
            return response()->json(['message' => 'Section Delete Successfully'], 200);
        } else {
            return response()->json(['message' => 'Section Not Found'], 404);
        }
    }
}
