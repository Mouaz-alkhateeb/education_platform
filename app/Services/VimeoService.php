<?php

namespace App\Services;

use Vimeo\Exceptions\VimeoRequestException;
use Vimeo\Vimeo;

class VimeoService
{
    protected $vimeo;

    public function __construct()
    {
        $this->vimeo = new Vimeo(
            config('services.vimeo.client_id'),
            config('services.vimeo.client_secret'),
            config('services.vimeo.access_token')
        );
    }

    public function createLiveEvent(array $data)
    {
        return $this->vimeo->request('/me/live_events', $data, 'POST');
    }


    public function uploadVideo($videoPath, $videoData)
    {
        $curlOptions = [
            CURLOPT_CAINFO => storage_path('cacert.pem'),
        ];

        $this->vimeo->setCurlOptions($curlOptions);

        try {
            $response = $this->vimeo->upload($videoPath, $videoData);
            return $response;
        } catch (VimeoRequestException $e) {
            return [
                'error' => 'Vimeo API Request Exception: ' . $e->getMessage(),
            ];
        }
    }

    public function endLiveEvent($liveEventId)
    {
        try {
            $response = $this->vimeo->request("/me/live_events/{$liveEventId}/end", [], 'POST');

            return $response;
        } catch (VimeoRequestException $e) {
            return [
                'error' => 'Vimeo API Request Exception: ' . $e->getMessage(),
            ];
        }
    }

    public function deleteLiveEvent($liveEventId)
    {
        try {
            $response = $this->vimeo->request("/me/live_events/{$liveEventId}", [], 'DELETE');

            return $response;
        } catch (VimeoRequestException $e) {
            return [
                'error' => 'Vimeo API Request Exception: ' . $e->getMessage(),
            ];
        }
    }

    public function getAllLiveEvents()
    {
        try {
            $response = $this->vimeo->request("/me/live_events", [], 'GET');
            return $response['body']['data'];
        } catch (VimeoRequestException $e) {
            return [
                'error' => 'Vimeo API Request Exception: ' . $e->getMessage(),
            ];
        }
    }


    public function deleteVideo($videoId)
    {
        try {
            $response = $this->vimeo->request("/videos/{$videoId}", [], 'DELETE');

            return $response['status'];
        } catch (VimeoRequestException $e) {
            return [
                'error' => 'Vimeo API Request Exception: ' . $e->getMessage(),
            ];
        }
    }

    public function getVideoLinks($videoId)
    {
        try {
            $response = $this->vimeo->request("/videos/{$videoId}?fields=play", [], 'GET', [
                'Accept' => 'application/vnd.vimeo.*+json;version=3.4'
            ]);

            return $response['body'];
        } catch (VimeoRequestException $e) {
            return [
                'error' => 'Vimeo API Request Exception: ' . $e->getMessage(),
            ];
        }
    }
}
