<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Craftsman;
use App\Models\CraftsmanType;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class CraftsmanTypeController extends Controller
{

    use GeneralTrait;

    public function ShowAllCraftsTypes(Request $request)
    {
        /* todo  func to check is user by token */
        $token = $request->token;
        $user = json_decode(User::select('user_id')->where('token',$token)->first(),true);

        $crafts_type = json_decode(CraftsmanType::show_all_crafts_type(),true);

        $new_data = [];
        if(!empty($crafts_type))
        {
            $counter = count($crafts_type);
            for ($i = 0; $i < $counter; $i++) {
                if (!is_null($crafts_type[$i]['craftsman_type_img'])) {
                    $crafts_type[$i]['craftsman_type_img'] = json_decode($crafts_type[$i]['craftsman_type_img'], true)['url'];
                    if(Storage::disk('uploads')->exists('craftsmen_types/'.$crafts_type[$i]['craftsman_type_img'])){
                        $crafts_type_url[$i] = asset('uploads/craftsmen_types/' . $crafts_type[$i]['craftsman_type_img']);
                        $crafts_type[$i]['craftsman_type_img'] = $crafts_type_url[$i];
                    }
                    else{
                        $crafts_type_url[$i] = asset('admin/site_imgs/avatar_craftsman.png');
                        $crafts_type[$i]['craftsman_type_img'] = $crafts_type_url[$i];                    }
                } else {
                    $crafts_type_url[$i] = asset('admin/site_imgs/avatar_craftsman.png');
                    $crafts_type[$i]['craftsman_type_img'] = $crafts_type_url[$i];
                }
                $new_data[$i] = $crafts_type[$i];
            }
            return $this->returnData('All_Craftsman_Types',$new_data);
        }
        else
        {
            return $this->returnError('404','The List Of Craftsman Type is Empty');
        }
    }
}
