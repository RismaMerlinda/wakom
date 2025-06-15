<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    protected function jsonResponse($success, $message, $data = null, $status = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
