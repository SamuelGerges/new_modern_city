<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;

class UserProfileController extends Controller
{

    use UploaderController;

    public function index()
    {
        $data['user_profile'] = Session::get('user_data');

        return view('admin/user_profile/index')->with($data);
    }


    public function edit_profile_info($id = null, Request $request)
    {




            /************** Edit User info ***************/
            if($request['data'] !== null){

                if ($request['data']['password'] != null){
                    $edit_password_rule = ['required', 'min:6', 'string'];
                    $data = $request->validate(User::validation($id, $edit_password_rule));
                    $data['data']['password']  = bcrypt($data['data']['password']);
                }
                else{
                    $data = $request->validate(User::validation($id));
                    unset($data['data']['password']);
                }


                if(isset($request['data']['user_img'])){

                    if(empty(User::findOrFail($id)->user_img)){
                        $old_img_name = null;
                    }
                    else {
                        // delete and create new file
                        $img_obj = User::findOrFail($id)->user_img;
                        $img_obj = json_decode($img_obj,true);
                        $old_img_name = $img_obj['url'];
                    }

                    $data['data'] = $this->single_img_upload($data['data'],'user_img','users', $old_img_name, 'user_avatar_img');
                }
                User::findOrFail($id)->update($data['data']);
                return redirect(route('admin.user.index'));
            }

            /**************  Fetch User info ***************/
            else{

                $data['user'] = User::findOrFail($id);
                $data['cities'] = City::select('city_id','city_name')->get();
                $data['users_groups'] = UserGroup::select('user_group_id','user_group_name')->get();

                return view('admin/users/create')->with($data);
            }


    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        return back();
    }


}
