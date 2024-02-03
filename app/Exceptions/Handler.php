<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;  // Import the PostTooLargeException class
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

     /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Handle the PostTooLargeException
        if ($exception instanceof PostTooLargeException) {
            $request['posttolargeFile'] = 'File to large';
            return redirect($request->getPathInfo().'?error=File to large')->with('newerror', 'File to large');
            // p($request->getRequestUri());
            // return $request->getRequestUri();
            
            // return parent::render($request, $exception);
            // return response()->view('errors.file_too_large', [], 422);
        }

        return parent::render($request, $exception);
    }
}
