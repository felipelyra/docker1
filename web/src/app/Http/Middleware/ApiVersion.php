<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Config; 
use Closure;

class ApiVersion {
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     *
     * @return mixed
     */
    public function handle($request, $next, $version)
    {
      #xxx
      config(['app.api_version' => $version]);

      //var_dump(Config::get('app.api_version'));
      return $next($request); 
    }
  }

