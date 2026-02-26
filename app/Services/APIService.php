<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class APIService {

    protected string $baseurl = 'https://lms.eduline.id/';

    public function getStats($page = 1, $filters = [])
    {
        $query = array_filter(array_merge([
            'page' => $page,
        ], $filters));

        $cacheKey = 'stats_' . md5(json_encode($query));

        return Cache::remember($cacheKey, 300, function () use ($query) {

            $response = Http::timeout(60)
                ->retry(3, 500)
                ->get($this->baseurl . 'api/cro', $query);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'totalSiswaPerBrand' => [],
                'studentSessionStats' => [
                    'data' => [],
                    'links' => [],
                    'from' => 0
                ]
            ];
        });
    }

    public function exportStats($filters = [])
    {
        $query = array_filter($filters);

        return $this->baseurl . 'api/cro/export?' . http_build_query($query);
    }

}