<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;


class AuthController extends Controller
{


    public function login()
    {
        return view('admin.auth.login');
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
            $admin = new Admin();
            $admin = $admin->show_user_type($data['email']);
            $method =strtolower('_'.$admin->user_group_name);

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
        // check if admin  are logged in or not
        return redirect(route('admin.login'));
    }


    /****************  Open Closed Principle ************/
    /****************     Methods For Types Of admins **************/

    private function _admins()
    {
        return redirect(route('admin.home'));
    }

    private function _users()
    {
        return redirect(route('front.homepage'));
    }

    private function _data_entry()
    {
        echo 'data_entry';
    }


}
