<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class UserGroup extends Model
{
    protected $primaryKey = 'user_group_id';
    protected $table = 'users_groups';
    protected $guarded = ['user_group_id'];
    protected $fillable = [
        'user_group_name',
    ];


    protected $hidden = [
    ];



    protected static function validation($group_id = null){



        if($group_id != NULL){
            $rule = Rule::unique('users_groups', 'user_group_name')->ignore($group_id, 'user_group_id');
        }
        else{
            $rule = Rule::unique('users_groups', 'user_group_name');
        }

        return [
            'data.user_group_name'  => ['required', 'string', 'max:50', $rule]
        ];
    }
}
