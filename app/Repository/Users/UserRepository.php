<?php

namespace App\Repository\Users;

use App\Filter\Users\UserFilter;
use App\Http\Trait\UploadImage;
use App\Models\User;
use App\Repository\BaseRepositoryImplementation;
use App\Statuses\UserType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepositoryImplementation
{
    use UploadImage;
    public function getFilterItems($filter)
    {

        $records = User::query();
        if ($filter instanceof UserFilter) {
            $records->when(isset($filter->name), function ($records) use ($filter) {
                $records->where('name', 'LIKE', '%' . $filter->getName() . '%');
            });
            return $records->get();
        }

        return $records->get();
    }

    public function model()
    {
        return User::class;
    }

    public function create_user($data)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            if (Arr::has($data, 'image')) {
                $file = Arr::get($data, 'image');
                $file_name = $this->uploadUserAttachment($file);
                $user->image = $file_name;
            }
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password  = Hash::make($data['password']);
            if (isset($data['phone'])) {
                $user->phone  = $data['phone'];
            }

            $user->role  = UserType::STUDENT;
            $user->save();
            DB::commit();
            return $user;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }
}
