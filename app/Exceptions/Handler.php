<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;

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
        //TokenMissmatchException発生時
        if($exception instanceof TokenMissmatchException) {
            //TokenMismatchException発生時はHomeページにリダイレクトさせる
            return next($request);
        }
        return parent::render($request, $exception);
    }

    // // オーバーライド
    // // 認証エラー時の対応
    // protected function unauthenticated(Request $request, AuthenticationException $exception) {
    //     if($request->expectsJson()) {
    //         return response()->json(['error' => 'Unauthenticated.'], 401);
    //     }
    //     if($request->is('shop') || $request->is('/owners/*')) {
    //
    //         return next('request');
    //     }
    //
    //     return next('request');
    // }
}
