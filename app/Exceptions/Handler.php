<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
        switch ($exception) {
            case $exception instanceof ServiceException;
                return response()->json(['code'=>$exception->getCode(),'message' => $exception->getMessage()], 400);
                break;
            case $exception instanceof ModelNotFoundException;
                $status = 404;
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => $exception->getMessage()], $status);
                } else {
                    abort(404);
                }
                break;
            case $exception instanceof NotFoundHttpException;
                abort(404);
                break;
            case $exception instanceof ValidationException;
                $msg = $exception->validator->getMessageBag()->toArray();
                if ($request->ajax() || $request->wantsJson()) {
                    $data = ['code'=>10000];
                    foreach($msg as $key => $message) {
                        $item = Array();
                        $item['name'] = $key;
                        $item['message'] = implode(',',$message);
                        $data['errors'][] = $item;
                    }
                    return response()->json($data, 400);
                } else {
                    //跳转网页
                    //dd($msg);
                    //
                    Echo '错误: 发生了网页跳转';
                    Exit;
                }
                break;
            case $exception instanceof HttpResponseException;

                break;
            default:

                break;
        }

        return parent::render($request, $exception);

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

        return redirect()->guest('login');
    }
}
