<?php

namespace App\Http\Controllers\Api\Craftsman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Craftsman;
use App\Models\CraftsmanType;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CraftsmanController extends Controller
{
    use GeneralTrait;

    public function RegisterCraftsman(Request $request)
    {
        if (is_null($request)) {
            $data['cities'] = City::select('city_id', 'city_name')->get();
            $data['crafts'] = CraftsmanType::select('craftsman_type_id', 'craftsman_type_name')->get();
            return response()->json($data);
        } else {
            $validator = Validator::make($request->all(), [
                'craftsman_type_id' => 'required|exists:craftsmen_types,craftsman_type_id',
                'city_id' => 'required|exists:cities,city_id',
                'first_name' => 'required|string|max:30',
                'last_name' => 'required|string|max:30',
                'email' => 'required|email|unique:users',
                'gender' => 'required|string|max:30',
                'password' => 'required|min:6|max:40',
                'address' => 'required|string|max:30',
                'geo_location_lat'  => 'nullable',
                'geo_location_long' => 'nullable',
                'phone' => 'required|unique:craftsmen|max:11',
                'description' => 'nullable|string',

            ]);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $token = Str::random(20).now().Str::random(21);
            $craft = new Craftsman(array_merge(
                    $validator->validated(),
                    [
                        'password' => bcrypt($request->password),
                        'work_state' => 0,
                        'token'      => $token,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])
            );
            $craft->save();
            return $this->returnSuccessMessage('200', 'Craftsman successfully registered');

        }

    }

    public function LoginCraftsman(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required"

        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
//            login
        $credentials = $request->only(['email', 'password']);
        Craftsman::where('email', $request->email)->update(['token' => Str::random(20) . now() . Str::random(21)]);
        $user_token = auth()->guard('api_crafts')->attempt($credentials);
        if (!$user_token) {
            return $this->returnError('E001', 'The Data is not Correct');
        }
        $crafts = Auth::guard('api_crafts')->user();

//        //return token
        return $this->returnData('Craftsman', $crafts,'This Data is selected');

    }
}
