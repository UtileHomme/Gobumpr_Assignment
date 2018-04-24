<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
         foreach(Auth::user()->role as $role)
         {
             //if the role is editor , proceed with the requested page , else
             if($role->name == 'admin')
             {
                         return $next($request);
             }

         }
         return redirect('');
     }
}
