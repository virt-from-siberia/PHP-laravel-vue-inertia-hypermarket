<?php

namespace App\Http\Middleware;

use App\Enums\Role\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->roles->contains('title', RoleEnum::ADMIN->value)) {
            return $next($request);
        }

        return  response([
            'message' => 'forbidden',
        ], Response::HTTP_FORBIDDEN);
    }
}
