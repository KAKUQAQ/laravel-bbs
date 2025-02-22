<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class EnsureEmailsVerified
{
    public function handle(Request $request, Closure $next)
    {
        //1.判断是否已登录
        //2.是否未认证email
        //3.访问的不是email相关链接或者退出的URL
        if ($request->user() && !$request->user()->hasVerifiedEmail() && !$request->is('email/*', 'logout'))
        {
            return $request->expectsJson()
                ? abort(403, 'You need to verify your email address before logging in.')
                :redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
