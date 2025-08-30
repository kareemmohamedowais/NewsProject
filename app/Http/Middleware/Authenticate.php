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
        // لو الراوت خاص بالإدمن → رجّعه على صفحة تسجيل دخول الإدمن
        if ($request->is('admin/*')) {
            return route('admin.login.show');
        }
        return $request->expectsJson() ? null : route('login');
    }
}
