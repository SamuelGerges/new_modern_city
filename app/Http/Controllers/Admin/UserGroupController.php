<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserGroup;
use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function PHPSTORM_META\type;
use SebastianBergmann\CodeCoverage\TestFixture\C;

class UserGroupController extends Controller
{

    public function index()
    {
        $data['users_groups'] = UserGroup::select('user_group_id', 'user_group_name')->orderBy('user_group_id', 'asc')->get();

        return view('admin/users_groups/index')->with($data);
    }

    public function create_or_edit($id = null, Request $request)
    {

        if($id != NULL){

            /************** Edit User Group info ***************/
            if($request['data'] !== null){

                $data = $request->validate(UserGroup::validation($id));

                UserGroup::findOrFail($id)->update($data['data']);
                return redirect(route('admin.user_group.index'));
            }
            /**************  Fetch UserGroup info ***************/
            else{

                $data['user_group'] = UserGroup::findOrFail($id);
                return view('admin/users_groups/create')->with($data);
            }
        }
        else{
            /************** Create User Group Info ***************/

            if ($request['data'] !== null){

                $data = $request->validate(UserGroup::validation($id));
                UserGroup::create($data['data']);
                return redirect(route('admin.user_group.index'));

            }
            /**************  show create view ***************/
            else{

                return view('admin/users_groups/create');
            }
        }
    }

    public function delete($id)
    {
        UserGroup::findOrFail($id)->delete();
        return back();

    }

}
