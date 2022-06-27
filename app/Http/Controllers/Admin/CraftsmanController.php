<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Craftsman;
use App\Http\Controllers\Controller;
use App\Models\CraftsmanType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class CraftsmanController extends Controller
{
    use UploaderController;

    public function index()
    {

        $data['craftsmen'] = Craftsman::select('craftsman_id', 'first_name', 'last_name', 'work_state', 'craftsman_type_id', 'city_id')->orderBy('craftsman_id', 'asc')->get();

        return view('admin/craftsmen/index')->with($data);
    }


    public function create_or_edit($id = null, Request $request)
    {

        if($id != NULL){
            /************** Edit Craftsman info ***************/
            if($request['data'] !== null){
                if ($request['data']['password'] != null){
                    $edit_password_rule = ['required', 'min:6', 'string'];
                    $data = $request->validate(Craftsman::validation($id, $edit_password_rule));
                    $data['data']['password']  = bcrypt($data['data']['password']);
                }
                else{
                    $data = $request->validate(Craftsman::validation($id));
                    unset($data['data']['password']);
                }


                if(isset($request['data']['craftsman_img'])){
                    if(empty(Craftsman::findOrFail($id)->craftsman_img)){
                        $old_img_name = null;
                    }
                    else{
                        // delete and create new file
                        $img_obj = Craftsman::findOrFail($id)->craftsman_img;
                        $img_obj = json_decode($img_obj);
                        $old_img_name = $img_obj->url;
                    }
                    $data['data'] = $this->single_img_upload($data['data'],'craftsman_img','craftsmen', $old_img_name,'craftsman_avatar_img');
                }

                Craftsman::findOrFail($id)->update($data['data']);
                return redirect(route('admin.craft.index'));
            }

            /**************  Fetch Craftsman info ***************/
            else{

                $data['craftsman'] = Craftsman::findOrFail($id);
                $data['cities'] = City::select('city_id','city_name')->get();
                $data['craftsman_types'] = CraftsmanType::select('craftsman_type_id','craftsman_type_name')->get();

                return view('admin/craftsmen/create')->with($data);
            }
        }
        else{
            /************** Create Craftsman Info ***************/

            if ($request['data'] !== null){
                $data = $request->validate(Craftsman::validation($id));
                $data['data']['password']  = bcrypt($data['data']['password']);

                $data['data'] = $this->single_img_upload($data['data'],'craftsman_img','craftsmen', null, 'craftsman_avatar_img');

                Craftsman::create($data['data']);
                return redirect(route('admin.craft.index'));

            }
            /**************  show create view ***************/
            else{

                $data['cities'] = City::select('city_id','city_name')->get();
                $data['craftsman_types'] = CraftsmanType::select('craftsman_type_id','craftsman_type_name')->get();
                return view('admin/craftsmen/create')->with($data);
            }
        }
    }

    public function delete($id)
    {
        Craftsman::findOrFail($id)->delete();
        return back();

    }

}
