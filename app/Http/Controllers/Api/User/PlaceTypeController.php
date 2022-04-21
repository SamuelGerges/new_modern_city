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
        $user =User::select('user_id')->where('token',$token)->first();
        $data = PlaceType::show_all_places_types();
        return $this->returnData('All_Places_Types',$data);
    }








}
