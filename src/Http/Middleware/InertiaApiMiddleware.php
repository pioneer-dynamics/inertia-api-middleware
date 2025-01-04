<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InertiaApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var \Illuminate\Http\Response $response
         */

        if($request->isApi())
        {
            $request->headers->set('Accept', 'application/json');
        }

        $response =  $next($request);
        
        if( $request->isApi()) {
            return response()->json(
                data: rescue(
                    callback: fn() => $response->original->getData()['page']['props'], 
                    rescue: fn() => $response->original), 
                status: $response->status()
            );
        }

        return $response;
    }
}
