<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class PaginatorHelper {

    /**
     * Format the paginator data for better readability.
     */
    public static function format(LengthAwarePaginator $data): array
    {
        return [
            'from' => $data->firstItem(),
            'to' => $data->lastItem(),
            'totalPages' => $data->lastPage(),
            'totalItems' => $data->total(),
            'currentPage' => $data->currentPage(),
            'previousPage' => $data->previousPageUrl(),
            'nextPage' => $data->nextPageUrl(),
        ];
    }
}