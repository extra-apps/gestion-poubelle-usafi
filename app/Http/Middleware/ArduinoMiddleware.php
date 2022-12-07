<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ArduinoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $response = $next($request);

        // $h = $request->headers;
        // foreach($h as $k=>$v){
        //     // $request->header->remove($k);
        // }
        // dd($response);
        // header_remove('Access-Control-Allow-Origin');
        return $next($request);
    }
}
