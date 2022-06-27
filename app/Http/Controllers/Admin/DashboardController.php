<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $data['num_of_new_users'] = count(DB::table("users")
            ->where('created_at', '>', now()->subDays(30)->endOfDay())
            ->get());


        $data['num_of_new_places'] = count(DB::table("places")
            ->where('created_at', '>', now()->subDays(30)->endOfDay())
            ->get());

        $data['num_of_new_craftsmen'] = count(DB::table("craftsmen")
            ->where('created_at', '>', now()->subDays(30)->endOfDay())
            ->get());

        $data['num_of_ads'] = count(DB::table("places")
            ->where('show_in_ads', '=', 1)
            ->get());

        $data['top_rate_of_craftsmen'] = count(DB::table("rate_craftsmen")
            ->groupBy('craftsman_id')
            ->where('rate' , '>', 4)
            ->get());


        $data['top_rate_of_places'] = count(DB::table("rate_places")
            ->groupBy('place_id')
            ->where('rate' , '>', 4)
            ->get());

        $data['num_of_famous_places'] = count(DB::table("places")
            ->where('show_in_famous_places', '=', 1)
            ->get());


        //dd($num_of_new_users);
        return view('admin/index')->with($data);
    }


}
