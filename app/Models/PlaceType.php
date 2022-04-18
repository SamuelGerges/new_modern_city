<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PlaceType extends Model
{

    protected $primaryKey = 'place_type_id';
    protected $table = 'places_types';
    protected $guarded = ['place_type_id'];
    protected $fillable = ['place_type_name', 'place_type_img'];

    protected $hidden = ['created_at','updated_at'];


    protected static function validation($place_id = null){

        if($place_id !== NULL){
            $rule = Rule::unique('places_types', 'place_type_name')->ignore($place_id, 'place_type_id');
        }
        else{
            $rule = Rule::unique('places_types', 'place_type_name');
        }

        return [
            'data.place_type_name'     => ['required', 'string', 'max:100', $rule],
            'data.place_type_img.url'  => ['image', 'mimes:jpg,jpeg,png'],
        ];
    }

    public static function show_all_places_types()
    {
        /*************** return all places types ****************/
        $all_places_types = DB::table('places_types')
                            ->select('place_type_id','place_type_name', 'place_type_img')
                            ->get();
        return $all_places_types;
    }


    public static function show_places_by_type($place_type_id)
    {
        /*************** return all places by places_type_id ****************/
        $places = DB::table('places')
            ->select('places.place_id', 'places.place_name', 'places.big_img', 'places_types.place_type_name')
            ->join('places_types', 'places.place_type_id', '=', 'places_types.place_type_id')
            ->where('places_types.place_type_id' , '=', $place_type_id)
            ->get();
        return $places;
    }

}
