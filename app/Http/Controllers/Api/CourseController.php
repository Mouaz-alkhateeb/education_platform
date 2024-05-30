<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\CreateCourseRequest;
use App\Http\Requests\Courses\GetCoursesList;
use App\Http\Requests\Courses\UpdateCourseRequest;
use App\Http\Resources\Courses\CourseResource;
use App\Services\Courses\CourseService;

class CourseController extends Controller
{
    public function __construct(private CourseService $courseService)
    {
    }
    public function create_course(CreateCourseRequest $request)
    {
        $createdData = $this->courseService->create_course($request->validated());

        $returnData = CourseResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }


    public function update_course(UpdateCourseRequest $request)
    {
        $createdData = $this->courseService->update_course($request->validated());

        $returnData = CourseResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function update_status($id)
    {
        $createdData = $this->courseService->update_status($id);

        $returnData = CourseResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }


    public function delete_course($id)
    {
        $deletionResult = $this->courseService->delete_course($id);

        if ($deletionResult) {
            return $deletionResult;
        } else {
            return response()->json(['message' => 'Error Deleting Course,Please Try Again'], 500);
        }
    }
    public function list_of_courses(GetCoursesList $request)
    {
        $data = $this->courseService->list_of_courses($request->generateFilter());
        $returnData = CourseResource::collection($data);

        return ApiResponseHelper::sendResponse(
            new Result($returnData, "DONE")
        );
    }
    public function show($id)
    {
        $reservationData = $this->courseService->show($id);
        $returnData = CourseResource::make($reservationData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData,  "DONE")
        );
    }
}
