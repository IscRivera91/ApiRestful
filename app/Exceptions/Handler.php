<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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

        });

        $this->renderable(function (Throwable $e) {

            if ($e instanceof NotFoundHttpException && $e->getPrevious()) {
                $e = $e->getPrevious();
            }

            if ($e instanceof ModelNotFoundException) {
                return $this->errorResponse('Model not found',Response::HTTP_NOT_FOUND);
            }

            if ($e instanceof NotFoundHttpException) {
                return $this->errorResponse('Url not found',Response::HTTP_NOT_FOUND);
            }

            if ($e instanceof ValidationException) {
                $errors = $e->validator->errors()->getMessages();
                return $this->errorResponse($errors,Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($e instanceof AuthenticationException) {
                return $this->errorResponse($e->getMessage(),Response::HTTP_FORBIDDEN);
            }

            if ($e instanceof AuthorizationException) {
                return $this->errorResponse('you don´t have permission to access',Response::HTTP_FORBIDDEN);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return $this->errorResponse('method not allowed',Response::HTTP_METHOD_NOT_ALLOWED);
            }

            if ($e instanceof HttpException) {
                return $this->errorResponse($e->getMessage(),$e->getStatusCode());
            }

            if ($e instanceof QueryException) {
                $mysqlCode = $e->errorInfo[1];
                if ($mysqlCode == 1451) {
                    return $this->errorResponse(
                        'Integrity constraint violation: Cannot delete or update a parent row',
                        Response::HTTP_CONFLICT
                    );
                }
            }

            return $this->errorResponse('internal server error',Response::HTTP_INTERNAL_SERVER_ERROR);

        });
    }

}
