<?php

namespace App\Http\Controllers\Admin;

use App\Models\PlaceType;
use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function PHPSTORM_META\type;
use SebastianBergmann\CodeCoverage\TestFixture\C;

class PlaceTypeController extends Controller
{
    use UploaderController;

    public function index()
    {
        $data['places_types'] = PlaceType::select('place_type_id', 'place_type_name')->orderBy('place_type_id', 'asc')->get();

        return view('admin/places_types/index')->with($data);
    }


    public function create_or_edit($id = null, Request $request)
    {

        if($id != NULL){

            /************** Edit User Group info ***************/
            if($request['data'] !== null){

                $data = $request->validate(PlaceType::validation($id));

                if(isset($request['data']['place_type_img'])) {
                    if (empty(PlaceType::findOrFail($id)->place_type_img)) {
                        $old_img_name = null;
                    }
                    else{
                        $img_obj = PlaceType::findOrFail($id)->place_type_img;
                        $img_obj = json_decode($img_obj);
                        $old_img_name = isset($img_obj->url) ? $img_obj->url : null;
                    }
                    $data['data'] = $this->single_img_upload($data['data'],'place_type_img','places_types', $old_img_name, 'place_type_img');
                }





                PlaceType::findOrFail($id)->update($data['data']);
                return redirect(route('admin.place_type.index'));
            }
            /**************  Fetch PlaceType info ***************/
            else{

                $data['place_type'] = PlaceType::findOrFail($id);
                return view('admin/places_types/create')->with($data);
            }
        }
        else{
            /************** Create User Group Info ***************/

            if ($request['data'] !== null){

                $data = $request->validate(PlaceType::validation($id));

                $data['data'] = $this->single_img_upload($data['data'],'place_type_img','places_types', null, 'place_type_img');
                PlaceType::create($data['data']);
                return redirect(route('admin.place_type.index'));

            }
            /**************  show create view ***************/
            else{

                return view('admin/places_types/create');
            }
        }
    }

    public function delete($id)
    {
        PlaceType::findOrFail($id)->delete();
        return back();

    }

}
