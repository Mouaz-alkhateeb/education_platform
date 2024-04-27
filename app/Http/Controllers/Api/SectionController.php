<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sections\CreateSectionRequest;
use App\Http\Requests\Sections\GetSectionsList;
use App\Http\Requests\Sections\UpdateSectionRequest;
use App\Http\Resources\Sections\SectionResource;
use App\Models\Section;
use App\Services\Sections\SectionService;

class SectionController extends Controller
{
    public function __construct(private SectionService $sectionService)
    {
    }
    public function create_section(CreateSectionRequest $request)
    {
        $createdData = $this->sectionService->create_section($request->validated());

        $returnData = SectionResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }
    public function update_section(UpdateSectionRequest $request)
    {
        $createdData = $this->sectionService->update_section($request->validated());

        $returnData = SectionResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }
    public function delete_section($id)
    {
        $deletionResult = $this->sectionService->delete_section($id);

        if ($deletionResult) {
            return $deletionResult;
        } else {
            return response()->json(['message' => 'Error Deleting Section,Please Try Again'], 500);
        }
    }
    public function list_of_sections(GetSectionsList $request)
    {
        $data = $this->sectionService->list_of_sections($request->generateFilter());
        $returnData = SectionResource::collection($data);

        return ApiResponseHelper::sendResponse(
            new Result($returnData, "DONE")
        );
    }
}
