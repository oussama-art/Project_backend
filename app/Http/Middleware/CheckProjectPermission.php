<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProjectPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $project = $request->route('project');
        $user = $request->user();

        // Vérifie que le projet existe et que l'utilisateur est bien le créateur
        if (! $project || $project->user_id !== $user->id) {
            return response()->json([
                'message' => 'You can only view or modify your own projects.'
            ], 403);
        }

        return $next($request);
    }

}
