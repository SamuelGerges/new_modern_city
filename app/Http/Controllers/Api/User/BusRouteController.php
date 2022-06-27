<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\BusRoute;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusRouteController extends Controller
{
    use GeneralTrait;
    public function GetBusRouteName(Request $request)
    {
        $token = $request->token;

        $bus_route_name = BusRoute::get_bus_routes_name();
        return $this->returnData('bus_routes_name',$bus_route_name);
    }

    public function GetBusRouteStation(Request $request)
    {
        $token = $request->token;
        $bus_route_id = $request->bus_route_id;
        $validator = Validator::make($request->all(), [
            "bus_route_id" => "required|exists:bus_routes,bus_route_id",

        ]);
        if ($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $bus_route_station = json_decode(BusRoute::get_bus_routes_station($bus_route_id), true);
        $bus_route_station[0]['bus_route_stations'] = explode("/", $bus_route_station[0]['bus_route_stations']);

//        return response()->json($bus_route_station);

        return $this->returnData('bus_routes_station',$bus_route_station);
    }
}
