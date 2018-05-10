<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use App\Candidat;

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
        $previous = url()->previous();
        
        if(strstr($previous,'?')) {
            $previous = "$previous&";
        } elseif($previous[strlen($previous)-1]!='?') {
            $previous = "$previous?";
        }
        
        if ($exception instanceof PostTooLargeException) {
            return redirect($previous.http_build_query( ['error'=>'PostTooLargeException'] ));
        } elseif ($exception instanceof FileNotFoundException) {
            $idCandidat = Candidat::select('id')->orderBy('id','desc')->first()->id;

            return redirect("candidats/$idCandidat/edit?".http_build_query( ['error'=>'FileNotFoundException'] ));
        }

        return parent::render($request, $exception);
    }
}
