<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function makeResponse($code, $message, $data = null, $pagination = null)
    {
        $response = [
            'code' => $code,
            'message' => $message,
        ];
        if ($data) $response['data'] = $data;
        if ($pagination) $response['pagination'] = $pagination;
        return response()->json($response);
    }
}
