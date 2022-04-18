<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function PHPSTORM_META\type;
use SebastianBergmann\CodeCoverage\TestFixture\C;

class CatController extends Controller
{

    public function index()
    {
        $data['cats'] = Cat::select('cat_id', 'cat_name')->orderBy('cat_id', 'desc')->get();

        return view('admin/cats/index')->with($data);
    }


    public function create_or_edit($id = null, Request $request)
    {

        if($id != NULL){

            /************** Edit Cat info ***************/
            if($request['data'] !== null){
                $data = $request->validate([
                    'data.cat_name'  => ['required', 'string', 'max:25',  Rule::unique('cats', 'cat_name')->ignore($id, 'cat_id') ],
                ]);

                Cat::findOrFail($id)->update($data['data']);
                return redirect(route('admin.cat.index'));
            }
            /**************  Fetch Cat info ***************/
            else{

                $data['cat'] = Cat::findOrFail($id);
                return view('admin/cats/create')->with($data);
            }
        }
        else{
            /************** Create Cat info ***************/

            if ($request['data'] !== null){

                $data = $request->validate([
                    'data.cat_name'  => ['required', 'string', 'max:25',  Rule::unique('cats', 'cat_name')],
                ]);
                Cat::create($data['data']);
                return redirect(route('admin.cat.index'));

            }
            /**************  show create view ***************/
            else{

                return view('admin/cats/create');
            }



        }



    }

    public function delete($id)
    {
        Cat::findOrFail($id)->delete();
        return back();

    }

}
