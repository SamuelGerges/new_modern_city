<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class CraftsmanType extends Model
{
    protected $table = 'craftsmen_types';
    protected $primaryKey = 'craftsman_type_id';
    protected $guarded = ['craftsman_type_id'];
    protected $fillable = [
        'craftsman_type_name', 'craftsman_type_img',
    ];

    protected $hidden = ['created_at','updated_at'];

    public $timestamps = true;



    protected static function validation($craftsman_id = null){



        if($craftsman_id != NULL){
            $rule = Rule::unique('craftsmen_types', 'craftsman_type_name')->ignore($craftsman_id, 'craftsman_type_id');
        }
        else{
            $rule = Rule::unique('craftsmen_types', 'craftsman_type_name');
        }

        return [
            'data.craftsman_type_name'    => ['required', 'string', 'max:100', $rule],
            'data.craftsman_type_img.url' => ['image', 'mimes:jpg,jpeg,png'],
        ];
    }


    public static function show_all_crafts_type()
    {
        $crafts_type = DB::table('craftsmen_types')->get();
        return $crafts_type;
    }

}
