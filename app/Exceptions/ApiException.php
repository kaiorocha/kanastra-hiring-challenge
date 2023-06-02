<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    public function render($request)
    {
        return response()->json([
            "error" => true,
            "message" => $this->getMessage()
        ])->setStatusCode(400);
    }
}
