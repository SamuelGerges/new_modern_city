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
        'place_name', 'slug', 'address', 'geo_location_lat', 'geo_location_long','description', 'show_in_ads',
        'show_in_famous_places', 'open_time', 'close_time', 'big_img', 'small_img', 'slider_img', 'place_type_id', 'city_id'
    ];


    protected $hidden = [
        'password',
    ];


    protected static function validation(){

        return[
            'data.place_name'             => ['required', 'string', 'max:100'],
            'data.slug'                   => ['required', 'string', 'max:200'],
            'data.address'                => ['required', 'string', 'max:200'],
            'data.geo_location_lat'       => ['numeric'],
            'data.geo_location_long'      => ['numeric'],
            'data.description'            => ['string'],
            'data.show_in_ads'            => ['required', 'integer', 'between:0,1'],
            'data.show_in_famous_places'  => ['required', 'integer', 'between:0,1'],
            'data.open_time'              => ['date_format:H'],
            'data.close_time'             => ['date_format:H'],
            'data.big_img'                => ['string'],
            'data.small_img'              => ['string'],
            'data.slider_img'             => ['string'],
            'data.city_id'                => ['required', 'exists:cities,city_id'],
            'data.place_type_id'          => ['required', 'exists:places_types,place_type_id'],
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
}
