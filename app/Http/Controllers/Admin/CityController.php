<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function PHPSTORM_META\type;
use SebastianBergmann\CodeCoverage\TestFixture\C;

class CityController extends Controller
{

    public function index()
    {
        $data['cities'] = City::select('city_id', 'city_name')->orderBy('city_id', 'asc')->get();

        return view('admin/cities/index')->with($data);
    }


    public function create_or_edit($id = null, Request $request)
    {

        if($id != NULL){

            /************** Edit User Group info ***************/
            if($request['data'] !== null){

                $data = $request->validate(City::validation($id));

                City::findOrFail($id)->update($data['data']);
                return redirect(route('admin.city.index'));
            }
            /**************  Fetch City info ***************/
            else{

                $data['city'] = City::findOrFail($id);
                return view('admin/cities/create')->with($data);
            }
        }
        else{
            /************** Create User Group Info ***************/

            if ($request['data'] !== null){

                $data = $request->validate(City::validation($id));
                City::create($data['data']);
                return redirect(route('admin.city.index'));

            }
            /**************  show create view ***************/
            else{

                return view('admin/cities/create');
            }
        }
    }

    public function delete($id)
    {
        City::findOrFail($id)->delete();
        return back();

    }

}
