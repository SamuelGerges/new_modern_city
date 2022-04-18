<?php

namespace App\Http\Controllers\Admin;

use App\Models\CraftsmanType;
use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function PHPSTORM_META\type;
use SebastianBergmann\CodeCoverage\TestFixture\C;

class CraftsmanTypeController extends Controller
{
    use UploaderController;

    public function index()
    {
        $data['craftsmen_types'] = CraftsmanType::select('craftsman_type_id', 'craftsman_type_name')->orderBy('craftsman_type_id', 'asc')->get();

        return view('admin/craftsmen_types/index')->with($data);
    }


    public function create_or_edit($id = null, Request $request)
    {

        if($id != NULL){

            /************** Edit User Group info ***************/
            if($request['data'] !== null){

                $data = $request->validate(CraftsmanType::validation($id));


                if(isset($request['data']['craftsman_type_img']['url']) && CraftsmanType::findOrFail($id)->craftsman_type_img != NULL){
                    // delete and create new file

                    $img_obj = CraftsmanType::findOrFail($id)->craftsman_type_img;
                    $img_obj = json_decode($img_obj);
                    $old_img_name = $img_obj->url;

                }
                else{
                    $old_img_name = null;
                }
                $data['data'] = $this->single_img_upload($data['data'],'craftsman_type_img','craftsman_type_img','craftsmen_types', $old_img_name);



                CraftsmanType::findOrFail($id)->update($data['data']);
                return redirect(route('admin.craft_type.index'));
            }
            /**************  Fetch CraftsmanType info ***************/
            else{

                $data['craftsman_type'] = CraftsmanType::findOrFail($id);
                return view('admin/craftsmen_types/create')->with($data);
            }
        }
        else{
            /************** Create User Group Info ***************/

            if ($request['data'] !== null){

                $data = $request->validate(CraftsmanType::validation($id));

                $data['data'] = $this->single_img_upload($data['data'],'craftsman_type_img','craftsman_type_img','craftsmen_types');

                CraftsmanType::create($data['data']);
                return redirect(route('admin.craft_type.index'));

            }
            /**************  show create view ***************/
            else{

                return view('admin/craftsmen_types/create');
            }
        }
    }



    public function delete($id)
    {
        CraftsmanType::findOrFail($id)->delete();
        return back();

    }

}
