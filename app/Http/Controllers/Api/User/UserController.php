<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use GeneralTrait;

    /**
     * @throws \Illuminate\Validation\ValidationException
     */


    public function RegisterUser(Request $request)
    {

        // req = null => cities  || req == val =>validation
        if (is_null($request)) {
            $data['cities'] = City::select('city_id', 'city_name')->get();
            return response()->json($data['cities']);
        }
        else{
            $validator = Validator::make($request->all(),[
                'city_id'      => 'required|exists:cities,city_id',
                'first_name'   => 'required|string|max:30',
                'last_name'    => 'required|string|max:30',
                'email'        => 'required|email|unique:users',
                'gender'       => 'required|string|max:30',
                'password'     => 'required|min:6|max:40',
                'address'      => 'required|string|max:30',
                'phone'        => 'required|numeric|unique:users|digits:11',
            ]);

            if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $token = Str::random(20).now().Str::random(21);

            $user = new User(array_merge(
                    $validator->validated(),
                    [
                        'password' => bcrypt($request->password) ,
                        'user_group_id' => 1,
                        'token'        => $token ,
                        'created_at'   => now(),
                        'updated_at'  => now(),
                    ])
            );
            $user->save();
            return $this->returnData('data',$user,'User successfully registered');
        }
    }


    public function EditUser(Request $request)
    {
        $token = $request->token;
        $user = User::select('user_id')->where('token',$token)->first();
        $validator = Validator::make($request->all(),[
            'first_name'   => 'required|string|max:30',
            'last_name'    => 'required|string|max:30',
            'password'     => 'required|min:6|max:40',
            'address'      => 'required|string|max:30',
            'phone'        => 'required|numeric|unique:users,phone,'.$user->user_id.',user_id|digits:11',

        ]);
        if($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $data = array_merge($validator->validated(),
            [
                'password' => bcrypt($request->password) ,
                'created_at'   => now(),
                'updated_at'  => now(),
            ]);
        $updated_data = User::where('user_id','=',$user->user_id)->update($data);
        return $this->returnSuccessMessage('updated_data','Successfully Updated');
    }
}
