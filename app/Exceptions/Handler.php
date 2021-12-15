<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\ApiResponser;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Route not found.',
                'data'  => null
            ], $e->getStatusCode());
        });

        $this->renderable(function (QueryException $e, $request) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Internal server error.',
                'data' => $e->getMessage()
            ], 500);
        });

        $this->renderable(function (HttpException $e, $request) {
            return response()->json([
                'status' => 'Failed',
                'message' => $e->getMessage(),
                'data'  => null
            ], $e->getStatusCode());
        });

    }
}
