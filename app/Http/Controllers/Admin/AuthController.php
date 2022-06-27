<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Craftsman;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{


    public function admin_profile(){

    }

    public function login()
    {

        if(Session::has('user_data')){
            return redirect(route('admin.home'));
        }
        return view('admin.auth.login2');

    }

    public function do_login(Request $request)
    {

        $data = $request->validate([
            'email' => 'required | email | max:191',
            'password' => 'required | string',
        ]);

        $auth = auth()->guard('admin')->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        /*********** check if admin are logged in or not **********/

        if ($auth) {

            $admin = new User();
            $admin = $admin->show_user_type($data['email']);
            $method = strtolower('_' . $admin->user_group_name);

            if (method_exists($this, $method)) {
                return $this->$method();
            } else {
                return back()->withErrors(['msg' => ' You don\'t have permission']);
            }

        } else {
            return back()->withErrors(['msg' => 'email or password invalid']);
        }
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        Session::forget('user_data');
        Session::save();
        return redirect(route('admin.login'));
    }


    /****************  Open Closed Principle ************/
    /****************     Methods For Types Of admins **************/

    private function _admins()
    {
        $user_data = json_decode(json_encode(DB::table('users')->first()), true);
        $user_data['group'] = "Admin";
        $user_data['city_name'] = User::show_user_city($user_data['city_id']);
        Session::put('user_data', $user_data);
        return redirect(route('admin.home'));
    }

    private function _user()
    {
        return redirect(route('front.homepage'));
    }


}
