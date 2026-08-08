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
       $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        $tenant = $user->tenant;

        // No tenant at all (employees, customers) — not gated here.
        if (!$tenant) {
            return $next($request);
        }

        // Step 1: business info never filled out
        if (!$tenant->business_setup_completed) {
            session()->flash('warning', 'Please complete your business setup before accessing this feature.');
            return redirect()->route('owner.business_setup');
        }

        // Step 2: filled out, waiting on admin review
        if ($tenant->verification_status === 'pending') {
            return redirect()->route('owner.business_approval');
        }

        // Step 3: admin rejected it — must be corrected and resubmitted
        if ($tenant->verification_status === 'rejected') {
            return redirect()->route('owner.business_rejected');
        }

        // Only reaches here when business_setup_completed = true AND verification_status = approved
        return $next($request);
    }
    }

