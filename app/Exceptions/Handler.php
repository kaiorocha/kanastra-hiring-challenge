<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'error' => true,
                'message' => 'Result Not Found!'
            ], 404);
        }

        if ($e instanceof InternalErrorException || $e instanceof QueryException) {
            return response()->json([
                'error' => true,
                'errorCode' => $e->getCode(),
                'message' => 'Internal Server Error!'
            ], 500);
        }

        return parent::render($request, $e);
    }
}
