<?php

namespace App\Http\Middleware;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Authenticate extends Middleware
{
protected  function unauthenticated($request, array $guards)
{
    if (! $request->expectsJson()) {
        //return route('home');
        throw new UnauthorizedHttpException('invalid token', 'Token is invalid');
    }
}
}
