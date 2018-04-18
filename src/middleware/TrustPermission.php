<?php


namespace Rabc\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
class TrustPermission
{

    protected $auth;
    const DELIMITER ='|';
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
    public function handle($request, Closure $next, $permissions)
    {
        if(!is_array($permissions)){
            $permissions = explode(self::DELIMITER);
        }
        if($this->auth->guest() || !$request->user()->can($permissions)){
            abort(403);
        }
        return $next($request);
    }
}