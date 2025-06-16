<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Check if it's a guru route
            if ($request->is('guru/*') || $request->is('dashboard') || $request->is('nilai-harian*') || $request->is('catatan-perkembangan*')) {
                return route('guru.login');
            }
            
            // Default to admin login
            return route('login.admin');
        }
        
        return null;
    }
}
