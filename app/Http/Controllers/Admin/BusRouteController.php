<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\BusRoute;
use Illuminate\Http\Request;



class BusRouteController extends Controller
{


    public function index()
    {

        $data['bus_routes'] = BusRoute::select('bus_route_id', 'bus_route_name', 'bus_route_stations')->orderBy('bus_route_id', 'asc')->get();
        return view('admin/bus_routes/index')->with($data);
    }


    public function create_or_edit($id = null, Request $request)
    {
        if($id != NULL){
            /************** Create Bus Route info ***************/
            if($request['data'] !== null){
                $data = $request->validate(BusRoute::validation($id));
                BusRoute::findOrFail($id)->update($data['data']);
                return redirect(route('admin.bus_route.index'));
            }
            /**************  Fetch BusRoute info ***************/
            else{

                $data['bus_route'] = BusRoute::findOrFail($id);
                return view('admin/bus_routes/create')->with($data);
            }
        }
        else{
            /************** Edit Bus Route Info ***************/
            if ($request['data'] !== null){

                $data = $request->validate(BusRoute::validation($id));
                BusRoute::create($data['data']);
                return redirect(route('admin.bus_route.index'));

            }
            /**************  show create view ***************/
            else{

                return view('admin/bus_routes/create');
            }
        }
    }

    public function delete($id)
    {
        BusRoute::findOrFail($id)->delete();
        return back();
    }


}
