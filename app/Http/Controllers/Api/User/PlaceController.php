<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    use GeneralTrait;

    // show_all_places_types => (token) => check is user
    // show_places_by_type => (token && place_type_id) ==>

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
            $data  = json_decode(Place::show_places_by_type($place_type_id), true);

            if(!empty($data)) {
                return $this->returnData('Places_By_Place_Type' ,$data);
            }
            else{
                return $this->returnError('404','This Place Type Not Have Any Places Data');
            }
        }
        else{
            return $this->returnError('404','Please Insert Place Id');
        }








    }

    public function ShowDetailsOfPlace(Request $request)
    {
        $token = $request->token;
        $user = json_decode(User::select('user_id')->where('token',$token)->first(),true);
        $user_id = (int)$user['user_id']; //return

        if (isset($request->place_id) && !is_null($request->place_id)){
            $place_id = (int)$request->place_id;
            $validator =  Validator::make($request->all(),[
                'place_id' => 'required|numeric|exists:places,place_id',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $data  = Place::show_datails_of_place($place_id);
            return $this->returnData('details_of_place' ,$data,'The Details of Place');
        }
        else{
            return $this->returnError('404','Please Insert Place Id');
        }
    }







}
