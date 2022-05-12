<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Favorite extends Model
{
    protected $table = 'favorite_places_lists';
    protected $primaryKey = 'fav_list_item_id';
    protected $guarded = ['fav_list_item_id'];
    protected $fillable =[];
    protected $hidden = ['created_at','updated_at','user_id'];

    public static function show_favourite_list($user_id)
    {
        $favourite_list =  DB::table('places')->select('places.place_id',
            'place_name', 'phone', 'address', 'geo_location_lat', 'geo_location_long','description',
             'open_time', 'close_time', 'big_img','favorite_places_lists.user_id'
        )->join('favorite_places_lists',
                'places.place_id', '=',
                'favorite_places_lists.place_id')
            ->where('favorite_places_lists.user_id','=', $user_id)
            ->get();
        return $favourite_list;
    }

}
