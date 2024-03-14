<?php

namespace App\Http\Middleware;

use App\Models\UserActivityLog as ModelsUserActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $responseData = $response->getContent();

        $userId = Auth::id();

        if ($userId == null) {
            $responseJson = json_decode($responseData, true);

            if (isset($responseJson['user']) && isset($responseJson['user']['id'])) {
                $userId = $responseJson['user']['id'];
            }
        }

        ModelsUserActivityLog::create([
            'service' => $request->path(),
            'user_id' => $userId,
            'body_request' => json_encode($request->all()),
            'body_response' => $responseData,
            'http_code' => $response->getStatusCode(),
            'ip_address' => $request->ip()
        ]);

        return $response;
    }
}
