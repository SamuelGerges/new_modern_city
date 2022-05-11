<?php

namespace App\Http\Controllers;

use App\Models\CraftsmanType;
use App\Models\Place;
use App\Models\PlaceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Psr7\str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       /* $this->middleware('auth',['except' => ['test']]);*/
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $validator = Validator::make($request->all(), [
//            'craftsman_img' => 'image|mimes:jpg,jpeg,png'
//        ]);
//        if ($validator->fails()) {
//            $code = $this->returnCodeAccordingToInput($validator);
//            return $this->returnValidationError($code, $validator);
//        }

        return view('welcome');
    }



    public function test()
    {
        return 'here is test function !';
    }
}
