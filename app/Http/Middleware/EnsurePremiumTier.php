<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePremiumTier
{
    /**
     * Handle an incoming request.
     * ✅ HIGHLIGHT: Intercepts requests to ensure the user has an active premium or agency subscription.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || in_array($request->user()->subscription_tier, ['premium', 'agency'], true) === false) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Premium subscription required to access this feature.',
                    'action' => 'upgrade_required'
                ], 403);
            }

            return redirect()->route('home')->with('status', 'Please upgrade to Premium to access this feature.');
        }

        return $next($request);
    }
}