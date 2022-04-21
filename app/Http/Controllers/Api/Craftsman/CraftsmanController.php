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
                'email' => 'required|email|unique:craftsmen',
                'gender' => 'required|string|max:30',
                'password' => 'required|min:6|max:40',
                'address' => 'required|string|max:30',
                'geo_location_lat'  => 'nullable',
                'geo_location_long' => 'nullable',
                'phone' => 'required|numeric|unique:craftsmen|digits:11',
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
            return $this->returnData('data',$craft ,'Craftsman successfully registered');

        }

    }

    public function EditCraftsman(Request $request)
    {
        $token = $request->token;
        $craftsman = Craftsman::select('craftsman_id')->where('token', $token)->first();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'password' => 'required|min:6|max:40',
            'address' => 'required|string|max:30',
            'phone' => 'required|numeric|unique:craftsmen,phone,'.$craftsman->craftsman_id.',craftsman_id|digits:11',
            'description' => 'nullable|string',

        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $data = array_merge($validator->validated(),
            [
                'password' => bcrypt($request->password) ,
                'created_at'   => now(),
                'updated_at'  => now(),
            ]);
        $updated_data = Craftsman::find($craftsman->craftsman_id)->update($data);
        return $this->returnSuccessMessage('200','successfully updated');
    }

    public function EditStatus(Request $request)
    {
        $token = $request->token;
        $craftsman = Craftsman::select('craftsman_id')->where('token', $token)->first();

        $validator = Validator::make($request->all(), [
            'status'    =>  'required|numeric',
        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $data = array_merge($validator->validated(),
            [
                'created_at'   => now(),
                'updated_at'  => now(),
            ]);
        $updated_data = Craftsman::find($craftsman->craftsman_id)->update($data);
        return $this->returnSuccessMessage('updated_data','successfully updated');
    }



}
