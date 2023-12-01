<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        always return json
//        $request->headers->set('Accept', 'application/json');
//        return $next($request);

//        return json only if request's header contains 'application/json'
        if ($request->wantsJson()) {
            return $next($request);
        }

        return response()->json([
            'error' => 'Only JSON is accepted',
            'message' => 'Please set header Accept: application/json',
        ], 406);
    }
}
