<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\VimeoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    protected $vimeoService;

    public function __construct(VimeoService $vimeoService)
    {
        $this->vimeoService = $vimeoService;
    }

    public function createLiveEvent(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'scheduled_datetime' => 'required|date_format:Y-m-d H:i:s',
            'description' => 'nullable|string',
            'privacy' => 'nullable|string',
        ]);

        $scheduledDatetime = Carbon::createFromFormat('Y-m-d H:i:s', $data['scheduled_datetime']);

        $response = $this->vimeoService->createLiveEvent([

            'name' => $data['title'],
            'scheduled_start_time' => $scheduledDatetime->toIso8601String(),
            'description' => $data['description'],
            'privacy' => [
                'view' => $data['privacy'] ?? 'anybody',
            ],
        ]);


        if (isset($response['body']['uri'])) {
            $eventUri = $response['body']['uri'];
            $eventLink = "https://vimeo.com" . $eventUri;

            return response()->json([
                'message' => 'Live event created successfully',
                'event_link' => $eventLink,
                'event_data' => $response['body'],
            ]);
        }

        return response()->json(['error' => 'Failed to create live event'], 500);
    }

    public function upload(Request $request)
    {
        set_time_limit(300);
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'privacy' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,mov,avi',
        ]);

        $file = $request->file('video');
        $filePath = $file->getPathname();

        $data = [
            'name' => $request->title,
            'description' => $request->description ?? '',
            'privacy' => [
                'view' => $request->privacy ?? 'anybody'
            ]
        ];

        $response = $this->vimeoService->uploadVideo($filePath, $data);

        return response()->json(["link" => $response]);
    }



    public function endEvent($liveEventId)
    {
        $response = $this->vimeoService->endLiveEvent($liveEventId);

        return response()->json($response);
    }

    public function deleteEvent(Request $request, $liveEventId)
    {
        $response = $this->vimeoService->deleteLiveEvent($liveEventId);

        return response()->json($response);
    }

    public function getAllLiveEvents(Request $request)
    {
        $liveEvents = $this->vimeoService->getAllLiveEvents();

        return response()->json($liveEvents);
    }

    public function deleteVideo($videoId)
    {
        $response = $this->vimeoService->deleteVideo($videoId);

        if (isset($response['error'])) {
            return response()->json($response, 500);
        }

        if ($response == 204) {
            return response()->json(['message' => 'Video deleted successfully'], 204);
        }

        return response()->json(['message' => 'Unable to delete video'], 500);
    }

    public function getVideoLinks($videoId)
    {
        $response = $this->vimeoService->getVideoLinks($videoId);

        if (isset($response['error'])) {
            return response()->json($response, 500);
        }

        return response()->json($response);
    }
}
