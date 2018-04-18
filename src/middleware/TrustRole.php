<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/18 0018
 * Time: 下午 5:06
 */

namespace Rabc\Middleware;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class TrustRole
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
    public function handle($request, Closure $next,$roles)
    {
        if (!is_array($roles)){
            $roles = explode(self::DELIMITER, $roles);
        }
        if($this->auth->guest() || !$request->user()->hasRole($roles)){
            abort(403,'access denied!');
        }
        return $next($request);
    }
}
