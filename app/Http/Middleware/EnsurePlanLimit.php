<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePlanLimit
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user->canAddListing()) {
            return redirect()->route('subscription.index')
                ->with('error', 'You have reached your listing limit. Please upgrade your plan.');
        }

        return $next($request);
    }
}
