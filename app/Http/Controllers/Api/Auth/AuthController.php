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

class AuthController extends Controller
{
    use GeneralTrait;
    public function Login(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required"

        ]);
        if ($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $credentials = $request->only(['email', 'password']);

        $login_type = $request->login_type;

        if($login_type === 'user'){
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
        elseif ($login_type === 'crafts'){
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

}
