<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\RatePlace;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    use GeneralTrait;

    public function ShowPlacesByType(Request $request)
    {
        /* todo  func to check is user by token */
        $token = $request->token;
        $user = User::select('user_id')->where('token',$token)->first();

        if (isset($request->place_type_id) && !is_null($request->place_type_id)){
            $place_type_id = (int)$request->place_type_id;
            $validator =  Validator::make($request->all(),[
                'place_type_id' => 'required|numeric|exists:places_types,place_type_id',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $place_data  = json_decode(Place::show_places_by_type($place_type_id), true);

            $new_data = [];
            if(!empty($place_data)) {
                $data_counter = count($place_data);
                for ($i = 0; $i < $data_counter; $i++)
                {
                    /**         Rate Place       **/
                    $place_id = $place_data[$i]['place_id'];
                    $place_data[$i]['place_rate']  = Place::show_rate_place($place_id);
                    $place_data[$i]['place_state'] = Place::show_place_state($place_id);
                    /**         Big Image For Place       **/

                    if (!is_null($place_data[$i]['big_img'])) {
                        $place_data[$i]['big_img'] = json_decode($place_data[$i]['big_img'], true)['url'];
                        if(Storage::disk('uploads')->exists('places/'.$place_data[$i]['big_img'])){
                            $place_data_url[$i] = asset('uploads/places/' .$place_data[$i]['big_img']);
                            $place_data[$i]['big_img'] = $place_data_url[$i];
                        }
                        else{
                            $place_data_url[$i] = asset('admin/site_imgs/place_big_img.png');
                            $place_data[$i]['big_img'] = $place_data_url[$i];
                        }
                    } else {
                        $place_data_url[$i] = asset('admin/site_imgs/place_big_img.png');
                        $place_data[$i]['big_img'] = $place_data_url[$i];
                    }


                    $new_data[$i] = $place_data[$i];
                }
                return $this->returnData('places_by_place_type' ,$new_data);
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

        if (isset($request->place_id) && !is_null($request->place_id)){
            $place_id = (int)$request->place_id;
            $validator =  Validator::make($request->all(),[
                'place_id' => 'required|numeric|exists:places,place_id',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $place_data  = json_decode(Place::show_datails_of_place($place_id),true)[0];


            if(!empty($place_data)) {

                /************ rate statments **************/
                $place_data['place_rate'] = Place::show_rate_place($place_id);
                $place_data['place_state'] = Place::show_place_state($place_id);

                /************* place Big img statments **************/
                if (!is_null($place_data['big_img'])) {
                    $place_data['big_img'] = json_decode($place_data['big_img'], true)['url'];
                    if (Storage::disk('uploads')->exists('places/' . $place_data['big_img'])) {
                        $place_data_url = asset('uploads/places/' . $place_data['big_img']);
                        $place_data['big_img'] = $place_data_url;
                    } else {
                        $place_data_url = asset('admin/site_imgs/place_big_img.png');
                        $place_data['big_img'] = $place_data_url;
                    }
                } else {
                    $place_data_url = asset('admin/site_imgs/place_big_img.png');
                    $place_data['big_img'] = $place_data_url;
                }

                /************* place Small img statments **************/
                if (!is_null($place_data['small_img'])) {
                    $place_data['small_img'] = json_decode($place_data['small_img'], true)['url'];
                    if (Storage::disk('uploads')->exists('places/' . $place_data['small_img'])) {
                        $place_data_url = asset('uploads/places/' . $place_data['small_img']);
                        $place_data['small_img'] = $place_data_url;
                    } else {
                        $place_data_url = asset('admin/site_imgs/place_small_img.png');
                        $place_data['small_img'] = $place_data_url;
                    }
                } else {
                    $place_data_url = asset('admin/site_imgs/place_small_img.png');
                    $place_data['small_img'] = $place_data_url;
                }

                /************* place slider imgs statments **************/
                if (!is_null($place_data['slider_img'])) {
                    $place_data['slider_img']  = json_decode($place_data['slider_img'], true);
                    $slider_counter = count($place_data['slider_img']);
                    for ($i = 0; $i < $slider_counter; $i++) {
                        if(isset($place_data['slider_img'][$i]['url'])){
                            if (Storage::disk('uploads')->exists("places/sliders/" . $place_data['slider_img'][$i]['url'])) {
                                $place_data_url = asset("uploads/places/sliders/" . $place_data['slider_img'][$i]['url']);
                                $place_data['slider_img'][$i] = $place_data_url;
                            } else {
                                unset($place_data['slider_img'][$i]);
                            }
                        }
                        else {
                            unset($place_data['slider_img'][$i]);
                        }
                    }

                    if(empty($place_data['slider_img'])){
                        $place_data_url = asset('admin/site_imgs/place_slider_img.png');
                        $place_data['slider_img'] = $place_data_url;
                    }

                } else {
                    $place_data_url = asset('admin/site_imgs/place_slider_img.png');
                    $place_data['slider_img'] = $place_data_url;
                }

                return $this->returnData('details_of_place',$place_data);

            }
            else{
                return $this->returnError('404','This Place Type Not Have Any Places Data');
            }
        }
        else{
            return $this->returnError('404','Please Insert Place Id');
        }
    }


    public function ShowFamousPlaces(Request $request)
    {
        $token = $request->token;
        $user = User::select('user_id')->where('token',$token)->first();
        $place_data = json_decode(Place::show_famous_places(),true);

        $new_data = [];
        if(!empty($place_data))
        {
            $counter = count($place_data);
            for($i = 0; $i< $counter; $i++)
            {
                if (!is_null($place_data[$i]['small_img']))
                {
                    $place_data[$i]['small_img'] = json_decode($place_data[$i]['small_img'], true)['url'];
                    if(Storage::disk('uploads')->exists('places/'.$place_data[$i]['small_img'])){
                        $place_data_url[$i] = asset('uploads/places/' . $place_data[$i]['small_img']);
                        $place_data[$i]['small_img'] = $place_data_url[$i];
                    }
                    else{
                        $place_data_url[$i] = asset('admin/site_imgs/place_small_img.png');
                        $place_data[$i]['small_img'] = $place_data_url[$i];
                    }
                } else {
                    $place_data_url[$i] = asset('admin/site_imgs/place_small_img.png');
                    $place_data[$i]['small_img'] = $place_data_url[$i];
                }

                $new_data[$i] = $place_data[$i];
            }

            return $this->returnData('famous_places',$new_data);
        }
        else
        {
            return $this->returnError('404','The List Of Famous Places is Empty');
        }
    }



    public function ShowPlacesAds(Request $request)
    {
        $token = $request->token;
        $user = User::select('user_id')->where('token',$token)->first();
        $place_data = json_decode(Place::show_advertisement(),true);

        $counter = count($place_data);
        $new_data = [];
        if(!empty($place_data))
        {
            for($i = 0; $i< $counter; $i++){
                if(!is_null($place_data[$i]['small_img'])) {
                    $place_data[$i]['small_img'] = json_decode($place_data[$i]['small_img'], true)['url'];
                    if(Storage::disk('uploads')->exists('places/'.$place_data[$i]['small_img'])){
                        $place_data_url[$i] = asset('uploads/places/' . $place_data[$i]['small_img']);
                        $place_data[$i]['small_img'] = $place_data_url[$i];
                    }
                    else{
                        $place_data_url[$i] = asset('admin/site_imgs/place_small_img.png');
                        $place_data[$i]['small_img'] = $place_data_url[$i];
                    }
                } else {
                    $place_data_url[$i] = asset('admin/site_imgs/place_small_img.png');
                    $place_data[$i]['small_img'] = $place_data_url[$i];
                }

                $new_data[$i] = $place_data[$i];
            }
            return $this->returnData('show_advertisement',$new_data);
        }
        else
        {
            return $this->returnError('404','The List Of Adevertisement For Places is Empty');
        }
    }


    public function AddRatePlace(Request $request)
    {
        $token = $request->token;
        $user = User::select('user_id')->where('token',$token)->first();
        if (isset($request->place_id) && !is_null($request->place_id)) {
            $place_id = (int) $request->place_id;
            $validator = Validator::make($request->all(),[
                'place_id' =>'required|numeric|exists:places,place_id',
                'rate' =>'required|numeric',

            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $place_in_rate_list_or_not = json_decode(RatePlace::select('rate')
                ->where([
                    'place_id' => $place_id,
                    'user_id'  => $user->user_id
                ])->get(),true);

            $data = array_merge($validator->validated(), ['user_id' => $user->user_id]);
            if (empty($place_in_rate_list_or_not)){
                $create = RatePlace::create($data);
                if($create){
                    return $this->returnSuccessMessage('200','Added Successfully');
                }
                else{
                    return $this->returnError('400','Added failed');
                }
            }
            else{
                $updated_rate =RatePlace::where(['place_id' => $place_id,'user_id' => $user->user_id])
                    ->update($data);
                if($updated_rate){
                    return $this->returnSuccessMessage('200','Updated Successfully');
                }
                else{
                    return $this->returnError('400','Updated failed');
                }
            }
        }
        else{
            return $this->returnError('404','Please Insert Place Id');
        }
    }

    public function GetNearestPlace(Request $request)
    {
        $token = $request->token;
        if (isset($request->geo_location_lat,$request->geo_location_long)){
            $latitude =  (double)$request->geo_location_lat;
            $longtitude = (double)$request->geo_location_long;

            $validator = Validator::make($request->all(),[
                'geo_location_lat' =>'required|numeric',
                'geo_location_long' =>'required|numeric',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }

            $data = Place::get_nearest_place($latitude,$longtitude);

            return $this->returnData('nearest_place',$data);
        }
        else{
            return $this->returnError('404','Please Insert Latitude and Longtitude');
        }

    }




}
