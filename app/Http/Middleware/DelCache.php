<?php

namespace App\Http\Middleware;

use Closure;
use Cache;

class DelCache
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request ,Closure $next , $model)
    {
        $uid = $request->user()->user_id;
        $page = 1;

        while(Cache::has($cache = $model.'-'.$uid.'-'.$page)){
            //echo $cache."<br>";
            Cache::forget($cache);
            $page++;
        }


        return $next($request);
    }
}