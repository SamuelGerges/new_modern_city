<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Craftsman;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    use GeneralTrait;


    // TODO :: Function Login
    public function Login(Request $request)
    {

        $login_type = $request->login_type;

        if($login_type == 'user'){
            $validator = Validator::make($request->all(), [
                "email" => "required|exists:users,email",
                "password" => "required"
            ]);
            if ($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $credentials = $request->only(['email', 'password']);
            //            login
            User::where('email',$request->email)->update(['token' => Str::random(20).now().Str::random(21)]);
            $user_token = auth()->guard('api_user')->attempt($credentials);
            if (!$user_token){
                return $this->returnError('E001', 'The Data is not Correct');
            }
            $user = Auth::guard('api_user')->user();

//        //return token
            return $this->returnData('User', $user,'This Data is selected');
        }
        elseif ($login_type == 'crafts'){
            $validator = Validator::make($request->all(), [
                "email" => "required|exists:craftsmen,email",
                "password" => "required"
            ]);
            if ($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $credentials = $request->only(['email', 'password']);
            //            login
            Craftsman::where('email', $request->email)->update(['token' => Str::random(20) . now() . Str::random(21)]);
            $crafts_token = auth()->guard('api_crafts')->attempt($credentials);
            if (!$crafts_token) {
                return $this->returnError('E001', 'The Data is not Correct');
            }
            $crafts = Auth::guard('api_crafts')->user();

//        //return token
            return $this->returnData('Craftsman', $crafts,'This Data is selected');
        }
        else {
            return $this->returnError('404','Your Choice is not Correct');
        }
    }



    // TODO :: Function Logout
    public function LogoutUser(Request $request)
    {
        if(auth()->guard('api_user')) {
            User::where('token',$request->token)->update(['token' => null]);
            auth()->guard('api_user');
            return$this->returnSuccessMessage('200','logout success');
        }
        else{
            return $this->returnError('','logout failed');

        }
    }

    public function LogoutCraftsman(Request $request)
    {
        if(auth()->guard('api_crafts')) {
            Craftsman::where('token',$request->token)->update(['token' => null]);
            auth()->guard('api_crafts');
            return $this->returnSuccessMessage('200','logout success');
        }
        else{
            return response()->json('logout failed');
        }
    }

}
