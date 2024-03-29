<?php

namespace App\Exceptions;

use GuzzleHttp\Psr7\Query;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

    

    public function render($request, \Throwable $exception)
    {
        $response = null;

        if ($exception instanceof AuthenticationException && $exception->guards() === ['api']) {
            $response = response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        if ($exception instanceof ValidationException) {
            $response = response()->json(['errors' => $exception->errors()], 422);
        }

        if ($exception instanceof ModelNotFoundException) {
            $response = response()->json([
                'error' => 'The resource was not founded.',
                'message' => $exception->getMessage() ?: 'Resource not found'
            ], 404);
        }
    
        if ($exception instanceof Query) {
            $response = response()->json([
                'error' => 'Error in query DB',
                'message' => $exception->getMessage() ?: 'Error in query DB'
            ], 500);
        }

        if ($response != null) {
            return $response;
        }

        return parent::render($request, $exception);
    }
}
