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

        $userId = Auth::id();

        if ($userId == null) {
            $responseData = $response->getContent();
            $responseJson = json_decode($responseData, true);

            if (isset($responseJson['user']) && isset($responseJson['user']['id'])) {
                $userId = $responseJson['user']['id'];
            }
        }

        ModelsUserActivityLog::create([
            'service' => $request->path(),
            'body_request' => json_encode($request->all()),
            'http_code' => $response->getStatusCode(),
            'user_id' => $userId
        ]);

        return $response;
    }
}
