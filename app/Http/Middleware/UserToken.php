<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Traits\GeneralTrait;

class UserToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (isset($request->token)){
            $token = $request->token;
            $user = User::select('user_id')->where('token', $token)->first();
            if(!empty($user)){
                // have auth
                return $next($request);
            }
            else{
                //not auth ==> error
                return $this->returnError('404','not auth');
            }
        }
        else {
            // not aut ==> error
            return $this->returnError('404','not auth');
        }    }
}
