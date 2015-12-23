<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Closure;

class Famille
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($this->auth->guest())
        {
            return response('Unauthorized.', 401);
        }

        if($user)
        {
            if(!$user->isFamily())
            {

                return redirect()->to('auth\login');
            }
            return $next($request);
        }


    }
}
