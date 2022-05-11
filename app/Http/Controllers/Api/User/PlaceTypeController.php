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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlaceTypeController extends Controller
{
    use GeneralTrait;

    public function ShowAllPlacesTypes(Request $request)
    {
        /* todo  func to check is user by token */
        $token = $request->token;
        $user =User::select('user_id')->where('token',$token)->first();

        $place_type = json_decode(PlaceType::show_all_places_types(),true);

        if(empty($place_type))
        {
            return $this->returnError('404','The List Of Place Type is Empty');
        }
        else
        {
            $counter = count($place_type);

            for ($i = 0; $i < $counter; $i++) {
                if (!is_null($place_type[$i]['place_type_img'])) {
                    $place_type[$i]['place_type_img'] = json_decode($place_type[$i]['place_type_img'], true)['url'];
                    if(Storage::disk('uploads')->exists('places_types/'.$place_type[$i]['place_type_img'])){
                        $place_type_url[$i] = asset('uploads/places_types/' . $place_type[$i]['place_type_img']);
                        $place_type[$i]['place_type_img'] = $place_type_url[$i];
                    }
                    else{

                        unset($place_type[$i]);
                    }
                } else {
                    unset($place_type[$i]);

                }

            }

            return $this->returnData('All_Places_Types',$place_type);
        }
    }








}
