<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
 /**
     * default status code.
     *
     * @var int
     */
    protected int $statusCode = 200;

    /**
     * get the status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * set the status code.
     *
     * @param [type] $statusCode [description]
     *
     */
    public function setStatusCode($statusCode): BaseController
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Respond.
     *
     * @param array $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function respond(array $data, array $headers = []): JsonResponse
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * respond with pagination.
     *
     * @param $items
     * @return JsonResponse
     */
    public function respondWithPagination($items): JsonResponse
    {
        $data = array_merge(
            [
                'status' => true,
                'code' => 200,
                'message' => '',
                'data' => $items->items(),
                'paginator' => [
                    'total_count' => $items->total(),
                    'total_pages' => $items->lastPage(),
                    'current_page' => $items->currentPage(),
                    'per_page' => $items->perPage(),
                ]
            ]);

        return $this->respond($data);
    }


    /**
     * Respond Created.
     *
     * @param $data
     * @param string|null $message
     *
     * @param int $status_code
     * @return JsonResponse
     */
    public function respondData($data, int $status_code = 200, string $message = null): JsonResponse
    {
        return $this->setStatusCode($status_code)
            ->respond([
                'status' => true,
                'code' => $status_code,
                'message' => $message,
                'data' => $data,
                'errors' => []
            ]);
    }

    /**
     * Respond Created.
     *
     * @param string|null $message
     *
     * @param int $status_code
     * @return JsonResponse
     */
    public
    function respondMessage(string $message = null, int $status_code = 200): JsonResponse
    {
        return $this->setStatusCode($this->getStatusCode())
            ->respond(['status' => true, 'code' => $status_code, 'message' => $message, 'data' => null, 'errors' => []]);
    }

    /**
     * Respond Created.
     *
     * @param string|null $message
     *
     * @param int $status_code
     * @return JsonResponse
     */
    public function respondError(string $message = null, int $status_code = 500): JsonResponse
    {
        return $this->setStatusCode($this->getStatusCode($status_code))
            ->respond([
                'status' => false,
                'code' => $status_code,
                'message' => $message,
                'data' => null,
                'errors' => []
            ]);
    }
}
