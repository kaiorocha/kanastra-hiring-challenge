<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            "error" => true,
            "message" => $this->getMessage()
        ])->setStatusCode(400);
    }
}
