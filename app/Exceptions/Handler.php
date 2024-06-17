<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Nếu là lỗi HTTP và mã lỗi là 404
        if ($exception instanceof HttpException && $exception->getStatusCode() == 404) {
            // Không xử lý và cho Laravel hiển thị trang lỗi mặc định
            return parent::render($request, $exception);
        }

        // Xử lý các loại lỗi khác như bình thường
        return $this->renderExceptionWithLayout($exception);
    }

    protected function renderExceptionWithLayout($exception)
    {
        // Sử dụng layout cho trang lỗi
        if (view()->exists('Page::error')) {
            return response()->view('Page::error', [
                'exception' => $exception,
            ], $exception instanceof \Illuminate\Http\Exceptions\HttpResponseException
                ? $exception->getResponse()->getStatusCode()
                : 500
            );
        }

        // Nếu không có layout, sử dụng layout mặc định
        return $this->convertExceptionToResponse($exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
