<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Place;
use App\Http\Controllers\Controller;
use App\Models\PlaceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class PlaceController extends Controller
{

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

                $data['data']['password']  = Crypt::encryptString($data['data']['password']);
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
