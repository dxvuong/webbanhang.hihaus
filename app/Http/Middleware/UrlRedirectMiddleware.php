<?php

namespace App\Http\Middleware;

use App\Modules\Home\Models\UrlRedirect;
use Closure;

class UrlRedirectMiddleware
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
        $currentUrl = $request->url();

        $redirect = UrlRedirect::where('url_old', $currentUrl)->first();

        if ($redirect && $redirect->url_new !== $currentUrl) {
            $reverseRedirect = UrlRedirect::where('url_old', $redirect->url_new)->first();

            if (empty($reverseRedirect)) {
                return redirect($redirect->url_new);
            }
        }

        return $next($request);
    }
}
