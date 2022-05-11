<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class City extends Model
{
    protected $primaryKey = 'city_id';
    protected $table = 'cities';
    protected $guarded = ['city_id'];
    protected $fillable = [
        'city_name',
    ];
    protected $hidden = [
    ];
    public $timestamps = false;


    protected static function validation($place_id = null)
    {

        if ($place_id != NULL) {
            $rule = Rule::unique('cities', 'city_name')->ignore($place_id, 'city_id');
        } else {
            $rule = Rule::unique('cities', 'city_name');
        }

        return [
            'data.city_name' => ['required', 'string', 'max:60', $rule]
        ];
    }

}
