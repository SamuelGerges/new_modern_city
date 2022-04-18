<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    use GeneralTrait;

    public function ShowFavorite(Request $request)
    {
        $token = $request->token; //
        $user = json_decode(User::select('user_id')->where('token',$token)->first(),true);
        $validator_user =  Validator::make($user,[
            'user_id' => 'numeric|exists:favorite_places_lists,user_id'
        ]);
        if($validator_user->fails()){
            $error = $this->returnCodeAccordingToInput($validator_user);
            return $this->returnValidationError($error, $validator_user);
        }
        $user_id = (int)$user['user_id'];
        $data  = Favorite::show_favourite_list($user_id);
        return $this->returnData('Places Favourite',$data);
    }
    public function AddToFavorite(Request $request)
    {
        $token = $request->token;
        $user = json_decode(User::select('user_id')->where('token',$token)->first(), true);
        $user_id = (int)$user['user_id'];
        if (isset($request->place_id) && !is_null($request->place_id)) {
            $place_id = (int) $request->place_id;
            $validator = Validator::make($request->all(),[
                'place_id' =>'required|numeric|exists:places,place_id'
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $place_in_list_or_not = json_decode(Favorite::select('fav_list_item_id')
                ->where([
                    'place_id' => $place_id,
                    'user_id'  => $user_id
                ])->get(),true);
            if (empty($place_in_list_or_not)){
                $fav = new Favorite(array_merge($validator->validated(),['user_id' => $user['user_id']]));
                $fav->save();
                return $this->returnSuccessMessage('200','Added Successfully');
            }
            else{
                return $this->returnError('404','This is already Place existed in your Favorite List');
            }
        }
        else{
            return $this->returnError('404','Please Insert Place Id');
        }
    }
    public function DeleteFromFavorite(Request $request)
    {
        $token = $request->token;
        $user = json_decode(User::select('user_id')->where('token',$token)->first(), true);
        if (isset($request->place_id) && !is_null($request->place_id)){
            $place_id = (int) $request->place_id;

            $validator = Validator::make($request->all(),[
                'place_id' =>'required|numeric|exists:favorite_places_lists,place_id'
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $validator_user =  Validator::make($user,[
                'user_id' => 'numeric|exists:favorite_places_lists,user_id'
            ]);
            if($validator_user->fails()){
                $error = $this->returnCodeAccordingToInput($validator_user);
                return $this->returnValidationError($error, $validator_user);
            }
            $query = Favorite::select('fav_list_item_id')
                ->where([
                    'place_id' => $place_id,
                    'user_id' => $user['user_id']
                ])->delete('fav_list_item_id');
            if($query) {
                return $this->returnSuccessMessage('200','Deleted Successfully');
            }else{
                return $this->returnError('','Deleted Failed');
            }
        }
        else{
            return $this->returnError('404','Please Insert Place Id');
        }
        /* return response()->json([$query]);*/
    }
}
