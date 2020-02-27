<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 5/31/2018
 * Time: 7:41 AM
 */

namespace App\Http\Middleware;

use Closure;

class CheckUser
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($request->session()->get("ospicareEmail") === null){
            return redirect('/hospital/login');
        }

        return $next($request);
    }

}