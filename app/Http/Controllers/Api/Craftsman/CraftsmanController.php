<?php

namespace App\Http\Controllers\Api\Craftsman;

use App\Http\Controllers\Admin\UploaderController;
use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Craftsman;
use App\Models\CraftsmanType;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class CraftsmanController extends Controller
{
    use GeneralTrait;
    use UploaderController;



    public function RegisterCraftsman(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'craftsman_type_id' => 'required|exists:craftsmen_types,craftsman_type_id',
                'city_id' => 'required|exists:cities,city_id',
                'first_name' => 'required|string|max:30',
                'last_name' => 'required|string|max:30',
                'email' => 'required|email|unique:craftsmen',
                'gender' => 'nullable|string|max:30',
                'password' => 'required|min:6|max:40',
                'address' => 'nullable|string|max:30',
                'geo_location_lat'  => 'nullable',
                'geo_location_long' => 'nullable',
                'phone' => 'nullable|numeric|unique:craftsmen|digits:11',
                'description' => 'nullable|string',

            ]);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $token = Str::random(20).now().Str::random(21);
            $craft = new Craftsman(array_merge(
                    $validator->validated(),
                    [
                        'password' => bcrypt($request->password),
                        'work_state' => 0,
                        'token'      => $token,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])
            );
            $craft->save();
            return $this->returnData('data',$craft ,'Craftsman successfully registered');



    }
    public function UploadImage(Request $request)
    {
        $token = $request->token;
        $craftsman = Craftsman::select('craftsman_id')->where('token', $token)->first();
        $craftsman_id = $craftsman->craftsman_id;

        $validator = Validator::make($request->all(), [
            'craftsman_img' => 'required|image|mimes:jpg,jpeg,png'
        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $data = $validator->validated();

        /************ sasa *****************/
        $old_img_name = isset(Craftsman::findOrFail($craftsman_id)->craftsman_img) ? json_decode(Craftsman::findOrFail($craftsman_id)->craftsman_img,true)['url'] : null;
        if($request->hasFile('craftsman_img')) {
            if($old_img_name != null && Storage::disk('uploads')->exists('craftsmen/'. $old_img_name)){
                Storage::disk('uploads')->delete('craftsmen/'. $old_img_name);
            }
            $new_name =  $data['craftsman_img']->hashName();
            Image::make($data['craftsman_img'])->save(public_path('uploads/craftsmen/'.$new_name));
            $data['craftsman_img'] = [
                'alt' => 'craftsman_image',
                'url' => $new_name,
            ];
        }

        $upload = Craftsman::findOrFail($craftsman_id)->update($data);
        if($upload) {
            return $this->returnSuccessMessage('200','Uploaded Success');
        }
        else{
            return $this->returnError('','Failed Success');
        }
    }
    public function UploadSingleImage(Request $request)
    {
        $token = $request->token;
        $craftsman = Craftsman::select('craftsman_id')->where('token', $token)->first();
        $craftsman_id = $craftsman->craftsman_id;

        $validator = Validator::make($request->all(), [
            'craftsman_slider' => 'required|image|mimes:jpg,jpeg,png'
        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $data = $validator->validated();

        /************ sasa *****************/
        $old_img_name = isset(Craftsman::findOrFail($craftsman_id)->craftsman_slider) ? json_decode(Craftsman::findOrFail($craftsman_id)->craftsman_slider,true)['url'] : null;
        if($request->hasFile('craftsman_slider')) {
            if($old_img_name != null && Storage::disk('uploads')->exists('craftsmen/sliders/'. $old_img_name)){
                Storage::disk('uploads')->delete('craftsmen/sliders/'. $old_img_name);
            }
            $new_img_name =  $data['craftsman_slider']->hashName();
            Image::make($data['craftsman_slider'])->save(public_path('uploads/craftsmen/sliders/'.$new_img_name));
            $data['craftsman_slider'] = [
                'alt' => 'craftsman_single_slider',
                'url' => $new_img_name,
            ];
        }

        $upload = Craftsman::findOrFail($craftsman_id)->update($data);
        if($upload) {
            return $this->returnSuccessMessage('200','Uploaded Success');
        }
        else{
            return $this->returnError('','Failed Success');
        }
    }

    public function UploadMultipleImage(Request $request)
    {
        $token = $request->token;
        $craftsman = Craftsman::select('craftsman_id')->where('token', $token)->first();
        $craftsman_id = $craftsman->craftsman_id;

        $imgs = $request->file('craftsman_slider');
        if(is_null($imgs)){
            return  $this->returnError('404','No Images Upload ');
        }
        $validator = Validator::make($request->all(), [
            'craftsman_slider.*' => 'image|mimes:jpg,jpeg,png,gif',
        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $counter = count($imgs);
        $slider_imgs = [];
        for ($i = 0; $i < $counter; $i++) {
            $data = $validator->validated();
                $new_img_name = $data['craftsman_slider'][$i]->hashName();
                Image::make($data['craftsman_slider'][$i])->save(public_path('uploads/craftsmen/sliders/' . $new_img_name));
                $slider_imgs[$i] = [
                    'alt' => 'craftsman_slider',
                    'url' => $new_img_name,
                ];
        }
        $slider_data['craftsman_slider'] = json_encode($slider_imgs);
        $upload = Craftsman::findOrFail($craftsman_id)->update($slider_data);
        if($upload) {
            return $this->returnSuccessMessage('200','Uploaded Success');
        }
        else{
            return $this->returnError('','Failed Success');
        }

    }
    public function EditCraftsman(Request $request)
    {
        $token = $request->token;
        $craftsman = Craftsman::select('craftsman_id')->where('token', $token)->first();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'password' => 'required|min:6|max:40',
            'address' => 'nullable|string|max:30',
            'phone' => 'nullable|numeric|unique:craftsmen,phone,'.$craftsman->craftsman_id.',craftsman_id|digits:11',
            'description' => 'nullable|string',

        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $data = array_merge($validator->validated(),
            [
                'password' => bcrypt($request->password) ,
                'created_at'   => now(),
                'updated_at'  => now(),
            ]);
        $updated_data = Craftsman::find($craftsman->craftsman_id)->update($data);
        return $this->returnSuccessMessage('200','successfully updated');
    }
    public function EditStatus(Request $request)
    {
        $token = $request->token;
        $craftsman = Craftsman::select('craftsman_id')->where('token', $token)->first();

        $validator = Validator::make($request->all(), [
            'status'    =>  'required|numeric',
        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $data = array_merge($validator->validated(),
            [
                'created_at'   => now(),
                'updated_at'  => now(),
            ]);
        $updated_data = Craftsman::find($craftsman->craftsman_id)->update($data);
        return $this->returnSuccessMessage('updated_data','successfully updated');
    }

    public function GetCraftsmanType()
    {
        $data_crafts_type = CraftsmanType::get_craftsman_type();
        return $this->returnData('get_crafts_type',$data_crafts_type);
    }


    public function ShowDetailsOfCraftsman(Request $request)
    {
        $token = $request->token;
        $crafts = Craftsman::select('craftsman_id')->where('token',$token)->first();

        $craftsman_id = $crafts->craftsman_id;

        if (isset($craftsman_id) && !is_null($craftsman_id)){
            $craftsman_data  = json_decode(Craftsman::show_datails_of_craftsman($craftsman_id),true)[0];
            if(!empty($craftsman_data)) {
                /**         Rate Craftsman        **/
                $craftsman_id = $craftsman_data['craftsman_id'];
                $craftsman_data['craftsman_rate']  = Craftsman::show_rate_craftsman($craftsman_id);

                /**       Fetched  Image Craftsman       **/
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
                /***  End Fetched Image Craftsman   **/

                /************* Fetched slider imgs statments **************/
                $slider = json_decode($craftsman_data['craftsman_slider'],true);


                if (!is_null($slider)) {
                    if (!isset($slider[0])) {
                        $data[0] = $slider;
                    } else {
                        $data = $slider;
                    }
                    $slider_counter = count($data);
                    for ($i = 0; $i < $slider_counter; $i++) {
                        if (Storage::disk('uploads')->exists("craftsmen/sliders/" . $data[$i]['url'])) {
                            $craftsman_data_urls[$i] = asset("uploads/craftsmen/sliders/" . $data[$i]['url']);
                        } else {
                            unset($data[$i]['url']);
                        }
                    }
                    $craftsman_data['craftsman_slider'] = $craftsman_data_urls;
                }
                else {
                    $craftsman_data_url = asset('admin/site_imgs/avatar_craftsman.png');
                    $craftsman_data['craftsman_slider'] = $craftsman_data_url;
                }
                return $this->returnData('details_of_craftsman' ,$craftsman_data,'The Details of Craftsman');
            }
            else{
                return $this->returnError('404','This Craftsman Type Not Have Any Crafts Data');
            }
        }
        else{
            return $this->returnError('404','Please Check of Token is Authenticate');
        }
    }

    public function ShowWorksOFCraftsman(Request $request)
    {
        $token = $request->token;
        $crafts = Craftsman::select('craftsman_id')->where('token',$token)->first();
        $craftsman_id = $crafts->craftsman_id;

        $craftsman_data  = json_decode(Craftsman::works_of_craftsman($craftsman_id),true)[0]['craftsman_slider'];
        $slider = json_decode($craftsman_data,true);

        if (!is_null($slider)) {
            if (!isset($slider[0])) {
                $data[0] = $slider;
            } else {
                $data = $slider;
            }
            $slider_counter = count($data);
            for ($i = 0; $i < $slider_counter; $i++) {
                if (Storage::disk('uploads')->exists("craftsmen/sliders/" . $data[$i]['url'])) {
                    $craftsman_data_urls[$i] = asset("uploads/craftsmen/sliders/" . $data[$i]['url']);

                } else {
                    unset($data[$i]['url']);
                }
            }
            return $this->returnData('works',$craftsman_data_urls);
        }
        else {
            $craftsman_data_url = asset('admin/site_imgs/avatar_craftsman.png');
            return $this->returnData('works_of_crafts',$craftsman_data_urls);
        }



        /***  End Fetched Image Craftsman   **/
    }





}
