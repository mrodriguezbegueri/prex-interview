<?php

namespace App\Http\Middleware;

use App\Models\UserActivityLog as ModelsUserActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserActivityLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        ModelsUserActivityLog::create([
            'service' => $request->path(),
            'body_request' => json_encode($request->all()),
            'http_code' => $response->getStatusCode(),
            'user_id' => $request->user()->id
        ]);

        return $response;
    }
}
