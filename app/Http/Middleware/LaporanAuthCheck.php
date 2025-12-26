<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LaporanAuthCheck
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika tidak authenticated, redirect ke help page atau login
        if (!auth()->check()) {
            \Log::warning('Laporan access denied - not authenticated', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            // Redirect ke help page yang menjelaskan perlu login
            return redirect()->route('laporan.help')->with('warning', 'Silahkan login terlebih dahulu untuk mengakses laporan kesehatan');
        }
        
        // Log successful auth check
        $user = auth()->user();
        \Log::info('Laporan auth check passed', [
            'user_id' => auth()->id(),
            'user_name' => $user ? $user->nama : 'unknown',
        ]);
        
        return $next($request);
    }
}
