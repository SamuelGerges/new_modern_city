<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Place extends Model
{
    protected $primaryKey = 'place_id';
    protected $table = 'places';
    protected $guarded = ['place_id', 'place_type_id', 'city_id'];
    protected $fillable = [
        'place_name', 'phone', 'address', 'geo_location_lat', 'geo_location_long','description', 'show_in_ads',
        'show_in_famous_places', 'open_time', 'close_time', 'big_img', 'small_img', 'slider_img', 'place_type_id', 'city_id'
    ];

    protected $hidden = ['created_at','updated_at'];



    protected static function validation(){

        return[
            'data.place_name'                 => ['required', 'string', 'max:100'],
            'data.phone'                      => ['required', 'numeric', 'min:11'],
            'data.address'                    => ['required', 'string', 'max:200'],
            'data.geo_location_lat'           => ['string'],
            'data.geo_location_long'          => ['string'],
            'data.description'                => ['nullable', 'string'],
            'data.show_in_ads'                => ['required', 'integer', 'between:0,1'],
            'data.show_in_famous_places'      => ['required', 'integer', 'between:0,1'],
            'data.open_time'                  => ['date_format:H:i'],
            'data.close_time'                 => ['date_format:H:i'],
            'data.big_img.url'                => ['image', 'mimes:jpg,jpeg,png'],
            'data.big_img.title'              => ['nullable', 'string'],
            'data.big_img.alt'                => ['nullable', 'string'],
            'data.small_img.url'              => ['image', 'mimes:jpg,jpeg,png'],
            'data.small_img.title'            => ['nullable', 'string'],
            'data.small_img.alt'              => ['nullable', 'string'],
            'data.slider_img.url.*'           => ['nullable'],
            'data.slider_img.src.*'           => ['nullable'],
            'data.slider_img.alt.*'           => ['nullable', 'string'],
            'data.slider_img.title.*'         => ['nullable', 'string'],
            'data.slider_img.deleted_urls.*'  => ['nullable', 'string'],
            'data.city_id'                    => ['required', 'exists:cities,city_id'],
            'data.place_type_id'              => ['required', 'exists:places_types,place_type_id'],
        ];
    }


    public function show_place_city($city_id)
    {
        $city = DB::table('cities')
            ->where('city_id', $city_id)
            ->value('city_name');
        return $city;
    }

    public function show_place_type($place_type_id)
    {
        $group = DB::table('places_types')
            ->where('place_type_id', $place_type_id)
            ->value('place_type_name');
        return $group;
    }


    public static function show_places_by_type($place_type_id)
    {
        /*************** return all places by places_type_id ****************/
        $places = DB::table('places')
            ->select('place_id', 'place_name','phone', 'geo_location_lat', 'geo_location_long','description' ,'big_img', 'places_types.place_type_name')
            ->join('places_types', 'places.place_type_id', '=', 'places_types.place_type_id')
            ->where('places_types.place_type_id' , '=', $place_type_id)
            ->get();
        return $places;
    }

    public static function show_place_state($place_id){


        $state_query = DB::table('places')
            ->where('place_id', '=', $place_id)
            ->where('open_time', '<=', now())
            ->where('close_time', '>=' , now())
            ->value('place_id');
        return !empty($state_query) ? 'open' : 'close';
    }




    public static function show_datails_of_place($place_id)
    {
        // TODO: return details of place

        $place_details = DB::table('places')
                        ->where('place_id','=',$place_id)
                        ->get();
        return $place_details;
    }
    public static function show_rate_place($place_id){

        $rate = DB::table('rate_places')
            ->where('place_id', '=', $place_id);
        if($rate->count() > 0){
            $rate_value = (int)round($rate->sum('rate') / $rate->count() );
            return $rate_value;
        }
        else{
            return 0;
        }
    }
    public static function show_famous_places()
    {
        $famous_places = DB::table('places')
            ->select('place_id','small_img')
            ->where('show_in_famous_places','=',1)
        ->get();
        return $famous_places;
    }
    public static function show_advertisement()
    {
        $advertisement = DB::table('places')
            ->select('place_id','small_img')
            ->where('show_in_ads','=',1)
            ->get();
        return $advertisement;
    }
    public static function get_nearest_place($lat ,$long)
    {
        $nearest_place = DB::table("places")
            ->select("place_id", "place_name",
                DB::raw("6371 * acos(cos(radians(" . $lat . "))
                * cos(radians(places.geo_location_lat))
                * cos(radians(places.geo_location_long) - radians(" . $long . "))
                + sin(radians(" .$lat. "))
                * sin(radians(places.geo_location_lat))) AS distance"))
            ->orderBy('distance', 'asc')
            ->get();
        return $nearest_place;
    }

}
