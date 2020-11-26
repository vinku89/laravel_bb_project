<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
		/*if ($exception instanceof \League\OAuth2\Server\Exception\OAuthServerException && $exception->getCode() == 9) {
			return response()->json(['message' => 'Unauthenticated'], 200);
		}*/
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
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {

            if ($request->expectsJson()) {
                return response()->json(['status'=>'Failure','message' => 'Unauthenticated.'], 200);
            }
            return redirect('/');
        }else{
            if ($exception instanceof \Illuminate\Http\Exceptions\PostTooLargeException) {
                return response()->view('errors.posttoolarge', [], 500 );
            }
            $exception = \Symfony\Component\Debug\Exception\FlattenException::create($exception);
		    $status = $exception->getStatusCode();

			//if status code is 501 redirect to custom view
			if( $status == 501 || $status == 503 ||  $status == 500 || $status == 405  ){
				 return response()->view('errors.500', [], 500 );
			}
			if( $status == 404 ){
				 return response()->view('errors.404', [], 404 );
			}
            return parent::render($request, $exception);
        }

    //    if ($exception instanceof \Illuminate\Auth\AuthenticationException) {

	// 		//echo "testset";exit;
	// 		//$exception = $this->unauthenticated($request, $exception);
	// 		if ($request->expectsJson()) {
	// 			return response()->json(['status'=>'Failure','message' => 'Unauthenticated.'], 200);
	// 		}
	// 		return redirect('/');
	// 	}else{

	// 		$exception = \Symfony\Component\Debug\Exception\FlattenException::create($exception);
	// 	    $status = $exception->getStatusCode() ;

	// 		//if status code is 501 redirect to custom view
	// 		if( $status == 501 || $status == 503 ||  $status == 500 || $status == 405  ){
	// 			 return response()->view('errors.500', [], 500 );
	// 		}
	// 		if( $status == 404 ){
	// 			 return response()->view('errors.404', [], 404 );
	// 		}
	// 		return parent::render($request, $exception);
    // 	}






    }
}
