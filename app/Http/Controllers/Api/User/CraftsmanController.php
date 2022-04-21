<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Craftsman;
use App\Models\CraftsmanType;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CraftsmanController extends Controller
{

    use GeneralTrait;

    // show_all_places_types => (token) => check is user
    // show_places_by_type => (token && place_type_id) ==>


    public function ShowCraftsByType(Request $request)
    {
        /* todo  func to check is user by token */
        $token = $request->token;
        $user = json_decode(User::select('user_id')->where('token',$token)->first(),true);
        $user_id = (int)$user['user_id']; //return
        //////////////////////////////////////////////////
        if (isset($request->craftsman_type_id) && !is_null($request->craftsman_type_id)){
            $craftsman_type_id = (int)$request->craftsman_type_id;
            $validator =  Validator::make($request->all(),[
                'craftsman_type_id' => 'required|numeric|exists:craftsmen_types,craftsman_type_id',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $data  = json_decode(Craftsman::show_craftsman_by_type($craftsman_type_id), true);

//            return \response()->json([$data, empty($data)]);

            if(!empty($data)) {
                return $this->returnData('Craftsmans_By_Craftsman_Type' ,$data);
            }
            else{
                return $this->returnError('404','This Craftsman Type Not Have Any Crafts Data');
            }
        }
        else{
            return $this->returnError('404','Please Insert Craftsman Type Id');
        }








    }


    public function ShowDetailsOfCraftsman(Request $request)
    {
        $token = $request->token;
        $user = json_decode(User::select('user_id')->where('token',$token)->first(),true);
        $user_id = (int)$user['user_id']; //return

        if (isset($request->craftsman_id) && !is_null($request->craftsman_id)){
            $craftsman_id = (int)$request->craftsman_id;
            $validator =  Validator::make($request->all(),[
                'craftsman_id' => 'required|numeric|exists:craftsmen,craftsman_id',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $data  = Craftsman::show_datails_of_craftsman($craftsman_id);
            return $this->returnData('details_of_craftsman' ,$data,'The Details of Craftsman');
        }
        else{
            return $this->returnError('404','Please Insert Craftsman Id');
        }
    }
}
