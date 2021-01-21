<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Throwable;
use ErrorException;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{

    use ApiResponser;
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception) && app()->bound('sentry')) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException)
            return $this->convertValidationExceptionToResponse($exception, $request);

        /**
         * Api Request
         */
        if (config('app.debug')) {

            return parent::render($request, $exception);
        }
        if ($request->expectsJson()) {


            if ($exception instanceof ThrottleRequestsException)
                return $this->errorResponse(__('validation.handler.max_attempts'), 429);

            if ($exception instanceof ValidationException)
                return $this->convertValidationExceptionToResponse($exception, $request);

            if ($exception instanceof ModelNotFoundException)
                return $this->errorResponse(__('validation.handler.resource_not_found'), 404);

            if ($exception instanceof AuthenticationException)
                return $this->unauthenticated($request, $exception);

            if ($exception instanceof NotFoundHttpException)
                return $this->errorResponse(__('validation.handler.resource_not_found_url'), 404);

            if ($exception instanceof RelationNotFoundException)
                return $this->errorResponse(__('validation.handler.relation_not_found'), 404);

            if ($exception instanceof AuthorizationException)
                return $this->errorResponse(__('validation.handler.unauthorized'), 403);

            if ($exception instanceof AccessDeniedHttpException)
                return $this->errorResponse(__('validation.handler.unauthorized'), 403);

            if ($exception instanceof MethodNotAllowedHttpException)
                return $this->errorResponse(__('validation.handler.method_allow'), 405);

            if ($exception instanceof HttpException)
                return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());



            if ($exception instanceof QueryException) {
                if ($exception->errorInfo[0] === "23503")
                    return $this->errorResponse(__('validation.handler.relation_not_delete'), 409);

                if ($exception->errorInfo[0] === "42S22")
                    return $this->errorResponse(__('validation.handler.column_not_found'), 409);

                if ($exception->errorInfo[0] === "42S02")
                    return $this->errorResponse(__('validation.handler.column_not_found'), 409);

                if ($exception->errorInfo[1] == 2002)
                    return $this->errorResponse(__('validation.handler.connection_refused', ['db' => 'MySQL']), 405);

                if ($exception->errorInfo[1] == 1451)
                    return $this->errorResponse(__('validation.handler.relation_not_delete'), 409);

                if ($exception->errorInfo[1] == 7)
                    return $this->errorResponse(__('validation.handler.conflict'), 409);

                if ($exception->getCode() == 7)
                    return $this->errorResponse(__('validation.handler.service_unavailable'), 503);

                if ($exception instanceof ErrorException)
                    return $this->errorResponse(__('validation.handler.unexpected_failure'), 500);
            }
        }

        return $this->errorResponse('Error inesperado', 500);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('No autenticado.', 401);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }
}
