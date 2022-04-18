<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\PlaceType;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PlaceTypeController extends Controller
{
    use GeneralTrait;

    // show_all_places_types => (token) => check is user
    // show_places_by_type => (token && place_type_id) ==>

    public function ShowAllPlacesTypes(Request $request)
    {
        /* todo  func to check is user by token */
        $token = $request->token;
        $user = json_decode(User::select('user_id')->where('token',$token)->first(),true);
        $user_id = (int)$user['user_id']; //return
        //////////////////////////////////////////////////
        $data = PlaceType::show_all_places_types();
        return $this->returnData('All Places Types',$data);
    }

    public function ShowPlacesByType(Request $request)
    {
        /* todo  func to check is user by token */
        $token = $request->token;
        $user = json_decode(User::select('user_id')->where('token',$token)->first(),true);
        $user_id = (int)$user['user_id']; //return
        //////////////////////////////////////////////////
        if (isset($request->place_type_id) && !is_null($request->place_type_id)){
            $place_type_id = (int)$request->place_type_id;
            $validator =  Validator::make($request->all(),[
                'place_type_id' => 'required|numeric|exists:places_types,place_type_id',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $data  = json_decode(PlaceType::show_places_by_type($place_type_id), true);

//            return \response()->json([$data, empty($data)]);

            if(!empty($data)) {
                return $this->returnData('Places By Place Type' ,$data);
            }
            else{
                return $this->returnError('404','This Place Type Not Have Any Places Data');
            }
        }
        else{
            return $this->returnError('404','Please Insert Place Id');
        }








    }


    public function wew()
    {

    }




}
