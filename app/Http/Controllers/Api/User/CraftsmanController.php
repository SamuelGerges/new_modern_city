<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Craftsman;
use App\Models\CraftsmanType;
use App\Models\RateCraftsman;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class CraftsmanController extends Controller
{

    use GeneralTrait;

    public function ShowCraftsByType(Request $request)
    {
        /* todo  func to check is user by token */
        $token = $request->token;
        $user = User::select('user_id')->where('token',$token)->first();

        if (isset($request->craftsman_type_id) && !is_null($request->craftsman_type_id)){
            $craftsman_type_id = (int)$request->craftsman_type_id;
            $validator =  Validator::make($request->all(),[
                'craftsman_type_id' => 'required|numeric|exists:craftsmen_types,craftsman_type_id',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $craftsman_data =json_decode(Craftsman::show_craftsman_by_type($craftsman_type_id), true);
            $new_data = [];

            if(!empty($craftsman_data)) {
                $data_counter = count($craftsman_data);
                for ($i = 0; $i < $data_counter; $i++){
                    /**         Rate Craftsman        **/
                    $craftsman_id = $craftsman_data[$i]['craftsman_id'];
                    $craftsman_data[$i]['craftsman_rate']  = Craftsman::show_rate_craftsman($craftsman_id);

                    /**         Image Craftsman       **/

                    if (!is_null($craftsman_data[$i]['craftsman_img'])) {
                        $craftsman_data[$i]['craftsman_img'] = json_decode($craftsman_data[$i]['craftsman_img'], true)['url'];
                        if(Storage::disk('uploads')->exists('craftsmen/'.$craftsman_data[$i]['craftsman_img'])){
                            $craftsman_data_url[$i] = asset('uploads/craftsmen/' . $craftsman_data[$i]['craftsman_img']);
                            $craftsman_data[$i]['craftsman_img'] = $craftsman_data_url[$i];
                        }
                        else{
                            $craftsman_data_url[$i] = asset('admin/site_imgs/avatar_craftsman.png');
                            $craftsman_data[$i]['craftsman_img'] = $craftsman_data_url[$i];
                        }
                    } else {
                        $craftsman_data_url[$i] = asset('admin/site_imgs/avatar_craftsman.png');
                        $craftsman_data[$i]['craftsman_img'] = $craftsman_data_url[$i];
                    }


                    $new_data[$i] = $craftsman_data[$i];
                }
                return $this->returnData('Craftsmans_By_Craftsman_Type' ,$new_data);
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
        $user = User::select('user_id')->where('token',$token)->first();

        if (isset($request->craftsman_id) && !is_null($request->craftsman_id)){
            $craftsman_id = (int)$request->craftsman_id;
            $validator =  Validator::make($request->all(),[
                'craftsman_id' => 'required|numeric|exists:craftsmen,craftsman_id',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $craftsman_data  = json_decode(Craftsman::show_datails_of_craftsman($craftsman_id),true)[0];

            if(!empty($craftsman_data)) {
                    /**         Rate Craftsman        **/
                    $craftsman_id = $craftsman_data['craftsman_id'];
                    $craftsman_data['craftsman_rate']  = Craftsman::show_rate_craftsman($craftsman_id);

                    /**         Image Craftsman       **/
                    if (!is_null($craftsman_data['craftsman_img'])) {
                        $craftsman_data['craftsman_img'] = json_decode($craftsman_data['craftsman_img'], true)['url'];
                        if(Storage::disk('uploads')->exists('craftsmen/'.$craftsman_data['craftsman_img'])){
                            $craftsman_data_url = asset('uploads/craftsmen/' . $craftsman_data['craftsman_img']);
                            $craftsman_data['craftsman_img'] = $craftsman_data_url;
                        }
                        else{
                            $craftsman_data_url = asset('admin/site_imgs/avatar_craftsman.png');
                            $craftsman_data['craftsman_img'] = $craftsman_data_url;
                        }
                    } else {
                        $craftsman_data_url = asset('admin/site_imgs/avatar_craftsman.png');
                        $craftsman_data['craftsman_img'] = $craftsman_data_url;
                    }
                return $this->returnData('details_of_craftsman' ,$craftsman_data,'The Details of Craftsman');
            }
            else{
                return $this->returnError('404','This Craftsman Type Not Have Any Crafts Data');
            }
        }
        else{
            return $this->returnError('404','Please Insert Craftsman Id');
        }
    }

    public function AddRateCraftsman(Request $request)
    {
        $token = $request->token;
        $user = User::select('user_id')->where('token',$token)->first();

        if (isset($request->craftsman_id) && !is_null($request->craftsman_id)) {
            $craftsman_id = (int) $request->craftsman_id;
            $validator = Validator::make($request->all(),[
                'craftsman_id' =>'required|numeric|exists:craftsmen,craftsman_id',
                'rate' =>'required|numeric',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $place_in_rate_list_or_not = json_decode(RateCraftsman::select('rate')
                ->where([
                    'craftsman_id' => $craftsman_id,
                    'user_id'  => $user->user_id
                ])->get(),true);

            $data = array_merge($validator->validated(), ['user_id' => $user->user_id]);
            if (empty($place_in_rate_list_or_not)){
                $create = RateCraftsman::create($data);
                if($create){
                    return $this->returnSuccessMessage('200','Added Successfully');
                }
                else{
                    return $this->returnError('400','Added failed');
                }
            }
            else{
                $updated_rate =RateCraftsman::where(['craftsman_id' => $craftsman_id,'user_id' => $user->user_id])
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
            return $this->returnError('404','Please Insert Craftsman Id');
        }
    }
}
