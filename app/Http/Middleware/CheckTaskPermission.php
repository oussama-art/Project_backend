<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTaskPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $task = $request->route('task');
        $user = $request->user();

        // Vérifie si le user est soit le créateur du projet, soit l’assigné
        if ($task->project->user_id !== $user->id && $task->assigned_to !== $user->id) {
            return response()->json([
                'message' => 'You cannot modify this task.'
            ], 403);
        }

        return $next($request);
    }
}
