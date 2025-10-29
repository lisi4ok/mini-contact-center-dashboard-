<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class InteractsWithJson
{
    private const HEADER = 'application/json, application/vnd.api+json';

    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('Accept', self::HEADER);
        $request->headers->set('Content-Type', self::HEADER);

        $response = $next($request);

        $response->headers->set('Content-Type', self::HEADER);

        return $response;
    }
}
