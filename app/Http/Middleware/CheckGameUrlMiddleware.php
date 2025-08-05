<?php

namespace App\Http\Middleware;

use App\Actions\CheckGameUrl;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class CheckGameUrlMiddleware
{
    public function __construct(
        private CheckGameUrl $checkGameUrl,
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->checkGameUrl->__invoke($request->gameUrl);

        return $next($request);
    }
}
