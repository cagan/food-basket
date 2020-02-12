<?php

namespace App\Exceptions;

use App\ResponseType;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->json(ResponseType::ROUTE_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json(ResponseType::MODEL_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof BadRequestHttpException) {
            return response()->json(ResponseType::BAD_REQUEST, Response::HTTP_BAD_REQUEST);
        }

        if ($exception instanceof RouteNotFoundException) {
            return response()->json(ResponseType::ROUTE_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $exception);
    }
}
