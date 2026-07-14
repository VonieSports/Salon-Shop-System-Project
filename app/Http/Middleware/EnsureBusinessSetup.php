<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureBusinessSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = Auth::user()?->tenant;

        if (!$tenant || !$tenant->business_setup_completed) {
            session()->flash('warning', 'Please complete your business setup before accessing this feature.');
            return redirect()->route('owner.dashboard');
        }

        return $next($request);
    }
    }

