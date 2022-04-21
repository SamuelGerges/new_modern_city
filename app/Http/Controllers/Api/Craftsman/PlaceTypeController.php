<?php

namespace App\Http\Controllers\Api\Craftsman;

use App\Http\Controllers\Controller;
use App\Models\Craftsman;
use App\Models\PlaceType;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;


class PlaceTypeController extends Controller
{
    use GeneralTrait;

    // show_all_places_types => (token) => check is user
    // show_places_by_type => (token && place_type_id) ==>

    public function ShowAllPlacesTypes(Request $request)
    {
        /* todo  func to check is user by token */
        $token = $request->token;
        $craftsman = Craftsman::select('craftsman_id')->where('token',$token)->first();
        $data = PlaceType::show_all_places_types();
        return $this->returnData('All_Places_Types',$data);
    }








}
