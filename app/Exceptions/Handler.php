<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
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

            if ($e->getPrevious()) {
                $e = $e->getPrevious();
            }

            if ($e instanceof ModelNotFoundException) {
                return $this->errorResponse('Model not found',404);
            }

            if ($e instanceof NotFoundHttpException) {
                return $this->errorResponse('Bad request',404);
            }

            if ($e instanceof ValidationException) {
                $errors = $e->validator->errors()->getMessages();
                return $this->errorResponse($errors,422);
            }

            if ($e instanceof AuthenticationException) {
                return $this->errorResponse($e->getMessage(),404);
            }
        });
    }

}
