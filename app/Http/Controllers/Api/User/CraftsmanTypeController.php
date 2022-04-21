<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Craftsman;
use App\Models\CraftsmanType;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CraftsmanTypeController extends Controller
{

    use GeneralTrait;

    // show_all_places_types => (token) => check is user
    // show_places_by_type => (token && place_type_id) ==>

    public function ShowAllCraftsTypes(Request $request)
    {
        /* todo  func to check is user by token */
        $token = $request->token;
        $user = json_decode(User::select('user_id')->where('token',$token)->first(),true);
        $user_id = (int)$user['user_id']; //return
        //////////////////////////////////////////////////
        $data = CraftsmanType::show_all_crafts_type();
        return $this->returnData('All_Craftsman_Types',$data);
    }
}
