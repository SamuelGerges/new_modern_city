<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class UserController extends Controller
{
    use GeneralTrait;

    /**
     * @throws \Illuminate\Validation\ValidationException
     */


    public function RegisterUser(Request $request)
    {

        // req = null => cities  || req == val =>validation
        if (is_null($request)) {
            $data['cities'] = City::select('city_id', 'city_name')->get();
            return response()->json($data['cities']);
        }
        else{
            $validator = Validator::make($request->all(),[
                'city_id'      => 'required|exists:cities,city_id',
                'first_name'   => 'required|string|max:30',
                'last_name'    => 'required|string|max:30',
                'email'        => 'required|email|unique:users',
                'gender'       => 'nullable|string|max:30',
                'password'     => 'required|min:6|max:40',
                'address'      => 'nullable|string|max:30',
                'phone'        => 'nullable|numeric|unique:users|digits:11',
            ]);

            if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $token = Str::random(20).now().Str::random(21);

            $user = new User(array_merge(
                    $validator->validated(),
                    [
                        'password' => bcrypt($request->password) ,
                        'user_group_id' => 1,
                        'token'        => $token ,
                        'created_at'   => now(),
                        'updated_at'  => now(),
                    ])
            );
            $user->save();
            return $this->returnData('data',$user,'User successfully registered');
        }
    }


    public function EditUser(Request $request)
    {
        $token = $request->token;
        $user = User::select('user_id')->where('token',$token)->first();
        $validator = Validator::make($request->all(),[
            'first_name'   => 'required|string|max:30',
            'last_name'    => 'required|string|max:30',
            'password'     => 'required|min:6|max:40',
            'address'      => 'nullable|string|max:30',
            'phone'        => 'nullable|numeric|unique:users,phone,'.$user->user_id.',user_id|digits:11',

        ]);
        if($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $data = array_merge($validator->validated(),
            [
                'password' => bcrypt($request->password) ,
                'created_at'   => now(),
                'updated_at'  => now(),
            ]);
        $updated_data = User::where('user_id','=',$user->user_id)->update($data);
        return $this->returnSuccessMessage('updated_data','Successfully Updated');
    }

    public function UploadImage(Request $request)
    {
        $token = $request->token;
        $user = User::select('user_id')->where('token', $token)->first();
        $user_id = $user->user_id;

        $validator = Validator::make($request->all(), [
            'user_img' => 'required|image|mimes:jpg,jpeg,png'
        ]);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $data = $validator->validated();

        $old_img_name = isset(User::findOrFail($user_id)->user_img) ? json_decode(User::findOrFail($user_id)->user_img,true)['url'] : null;
        if($request->hasFile('user_img')) {
            if($old_img_name != null && Storage::disk('uploads')->exists('users/'. $old_img_name)){
                Storage::disk('uploads')->delete('users/'. $old_img_name);
            }
            $new_name =  $data['user_img']->hashName();
            Image::make($data['user_img'])->resize(200,200)->save(public_path('uploads/users/'.$new_name));
            $data['user_img'] = [
                'alt' => 'user_image',
                'url' => $new_name,
            ];
        }
        $upload = User::findOrFail($user_id)->update($data);
        if($upload) {
            return $this->returnSuccessMessage('200','Uploaded Success');
        }
        else{
            return $this->returnError('','Failed Uploading');
        }
    }



    public function ShowDetailsOfUser(Request $request)
    {
        $token = $request->token;
        $user = User::select('user_id')->where('token',$token)->first();

        if (isset($request->user_id) && !is_null($request->user_id)){
            $user_id = (int)$request->user_id;
            $validator =  Validator::make($request->all(),[
                'user_id' => 'required|numeric|exists:users,user_id',
            ]);
            if($validator->fails()){
                $error = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($error, $validator);
            }
            $details_of_user  = json_decode(User::show_datails_of_user($user_id),true)[0];

            if(!empty($details_of_user))
            {
                    /**         Image User       **/
                    if (!is_null($details_of_user['user_img'])) {
                        $details_of_user['user_img']= json_decode($details_of_user['user_img'], true)['url'];
                        if(Storage::disk('uploads')->exists('users/'.$details_of_user['user_img'])){
                            $details_of_user_url = asset('uploads/users/' . $details_of_user['user_img']);
                            $details_of_user['user_img'] = $details_of_user_url;
                        }
                        else{
                            $details_of_user_url = asset('admin/site_imgs/avatar_user.png');
                            $details_of_user['user_img'] = $details_of_user_url;
                        }
                    } else {
                        $details_of_user_url = asset('admin/site_imgs/avatar_user.png');
                        $details_of_user['user_img'] = $details_of_user_url;
                    }

                return $this->returnData('details_of_user' ,$details_of_user,'The Details of User');
            }
            else{
                return $this->returnError('404','This User Not Have Any Data');
            }
        }
        else{
            return $this->returnError('404','Please Insert User Id');
        }
    }

}
