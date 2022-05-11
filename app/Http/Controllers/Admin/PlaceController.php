<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Place;
use App\Http\Controllers\Controller;
use App\Models\PlaceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use function Symfony\Component\String\s;


class PlaceController extends Controller
{
    use UploaderController;


    public $big_img_old_name = null;

    public function index()
    {

        $data['places'] = Place::select('place_id', 'place_name', 'city_id', 'place_type_id', 'show_in_ads','show_in_famous_places')->orderBy('place_id', 'asc')->get();

        return view('admin/places/index')->with($data);
    }

    public function create_or_edit($id = null, Request $request)
    {

        if($id != NULL){

            /************** Edit Place info ***************/
            if($request['data'] !== null){

                $data = $request->validate(Place::validation($id));
                //--------------------- Big image ---------------------//
                if(isset($request['data']['big_img'])){
                    if(empty(Place::findOrFail($id)->big_img)){
                        $old_img_name = null;
                    }
                    else{
                        $img_obj = Place::findOrFail($id)->big_img;
                        $img_obj = json_decode($img_obj);
                        $old_img_name = isset($img_obj->url) ? $img_obj->url : null;
                    }
                    $data['data'] = $this->single_img_upload($data['data'],'big_img','places', $old_img_name);
                }

                //--------------------- Small image ---------------------//
                if(isset($request['data']['small_img'])){
                    if(empty(Place::findOrFail($id)->small_img)){
                        // Create new file only
                        $old_img_name = null;
                    }
                    else{
                        // delete old img and create new img
                        $img_obj = Place::findOrFail($id)->small_img;
                        $img_obj = json_decode($img_obj);
                        $old_img_name = isset($img_obj->url) ? $img_obj->url : null;
                    }
                    $data['data'] = $this->single_img_upload($data['data'],'small_img','places', $old_img_name);

                }
                //--------------------- Small image ---------------------//
                if(isset($request['data']['slider_img'])){
                    $data['data'] = $this->slider_img_upload($data['data'], 'slider_img','places/sliders');
                }
                Place::findOrFail($id)->update($data['data']);
                return redirect(route('admin.place.index'));
            }

            /**************  Fetch Place info ***************/
            else{
                $data['place'] = Place::findOrFail($id);
                $data['cities'] = City::select('city_id','city_name')->get();
                $data['places_types'] = PlaceType::select('place_type_id','place_type_name')->get();

                return view('admin/places/create')->with($data);
            }
        }
        else{
            /************** Create Place Info ***************/

            if ($request['data'] !== null){

                $data = $request->validate(Place::validation($id));

                /**************  big image ***************/
                $data['data'] = $this->single_img_upload($data['data'],'big_img','places');

                /**************  small image ***************/
                $data['data'] = $this->single_img_upload($data['data'],'small_img','places');

                if(isset($request['data']['slider_img'])){
                    $data['data'] = $this->slider_img_upload($data['data'], 'slider_img','places/sliders');
                }

                Place::create($data['data']);
                return redirect(route('admin.place.index'));

            }
            /**************  show create view ***************/
            else{
                $data['cities'] = City::select('city_id', 'city_name')->get();
                $data['places_types'] = PlaceType::select('place_type_id','place_type_name')->get();
                return view('admin/places/create')->with($data);
            }
        }
    }

    public function delete($id)
    {
        Place::findOrFail($id)->delete();
        return back();
    }

}
