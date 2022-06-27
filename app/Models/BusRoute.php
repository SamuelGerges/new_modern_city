<?php

namespace App\Models;

use Dotenv\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BusRoute extends Model
{

    protected $primaryKey = 'bus_route_id';
    protected $table = 'bus_routes';
    protected $guarded = ['bus_route_id'];
    protected $fillable = [
        'bus_route_name', 'bus_route_stations', 'bus_route_id'
    ];


    protected static function validation(){


        return [
            'data.bus_route_name'  => ['required', 'string'],
            'data.bus_route_stations'  => ['required', 'string'],
        ];
    }



    public static function get_bus_routes_name()
    {
        $bus_routes = DB::table('bus_routes')
            ->select('bus_route_id','bus_route_name')
            ->get();
        return $bus_routes;
    }

    public static function get_bus_routes_station($bus_route_id)
    {
        $bus_routes = DB::table('bus_routes')
            ->select('bus_route_name','bus_route_stations')
            ->where('bus_route_id','=',$bus_route_id)
            ->get();
        return $bus_routes;
    }

}
