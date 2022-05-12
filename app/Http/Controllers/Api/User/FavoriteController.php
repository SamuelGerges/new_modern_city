<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


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
        $place_data  = json_decode(Favorite::show_favourite_list($user_id),true);

        $data_counter = count($place_data);

        $new_data = [];
        if(!empty($place_data))
        {
            for ($i = 0; $i < $data_counter; $i++)
            {
                /************ rate statments **************/
                $place_id = $place_data[$i]['place_id'];

                $place_data[$i]['place_rate'] = Place::show_rate_place($place_id);
                $place_data[$i]['place_state'] = Place::show_place_state($place_id);


                /************* place big img statments **************/
                if (!is_null($place_data[$i]['big_img'])) {
                    $place_data[$i]['big_img'] = json_decode($place_data[$i]['big_img'], true)['url'];
                    if (Storage::disk('uploads')->exists('places/' . $place_data[$i]['big_img'])) {
                        $place_data_url[$i] = asset('uploads/places/' . $place_data[$i]['big_img']);
                        $place_data[$i]['big_img'] = $place_data_url[$i];
                    } else {
                        $place_data_url[$i] = asset('admin/site_imgs/place_big_img.png');
                        $place_data[$i]['big_img'] = $place_data_url[$i];
                    }
                } else {
                    $place_data_url[$i] = asset('admin/site_imgs/place_big_img.png');
                    $place_data[$i]['big_img'] = $place_data_url[$i];
                }
                $new_data[$i] = $place_data[$i];

            }
            return $this->returnData('Places_Favourite',$new_data);
        }
        else{
            return $this->returnError('404','This Place not Have Any Places Data');
        }
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
    }
}
