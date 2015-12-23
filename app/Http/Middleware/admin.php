<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Closure;

class admin
{

    protected $auth;



    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($this->auth->guest())
        {
            return response('Unauthorized.', 401);
        }

        if($user)
        {
            if(!$user->isAdmin())
            {
                return redirect()->to('auth\login');
            }
            return $next($request);
        }
        return $next($request);
    }
}
