<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use Dotenv\Validator;
use Illuminate\Validation\Rule;

class Craftsman extends Authenticatable implements JWTSubject
{
    protected $table = 'craftsmen';
    protected $primaryKey = 'craftsman_id';
    protected $guarded = ['craftsman_id','city_id','craftsman_type_id','token'];
    protected $fillable = [
        'first_name', 'last_name', 'email', 'gender', 'password', 'address', 'phone', 'work_state','craftsman_type_id',
        'city_id', 'description','craftsman_img','token',
    ];


    protected $hidden = [
        'password','created_at','updated_at'
    ];


    public function show_craftsman_city($city_id)
    {
        $city = DB::table('cities')
            ->where('city_id', $city_id)
            ->value('city_name');
        return $city;
    }


    public function show_craftsman_type($craft_type_id)
    {

        $group = DB::table('craftsmen_types')
            ->where('craftsman_type_id', $craft_type_id)
            ->value('craftsman_type_name');
        return $group;
    }


    protected static function validation($user_id = null, $edit_password_rule = []){



        if($user_id != NULL){
            /**************  edit validation  ***************/
            $email_rule = Rule::unique('users', 'email')->ignore($user_id, 'user_id');
            $phone_rule = Rule::unique('users', 'phone')->ignore($user_id, 'user_id');
            $password_rule = $edit_password_rule;
            $confirm_password_rule = ['string'];



        }
        else{
            /************** create validation  ***************/
            $email_rule = Rule::unique('users', 'email');
            $phone_rule = Rule::unique('users', 'phone');
            $password_rule = ['required', 'min:6', 'string'];
            $confirm_password_rule = ['required', 'same:data.password'];

        }


        return[


            'data.first_name'        => ['required', 'string', 'max:30'],
            'data.last_name'         => ['required', 'string', 'max:30'],
            'data.email'             => ['required', 'string', 'email', 'max:100', $email_rule],
            'data.gender'            => ['required', 'in:male,female'],
            'data.password'          => $password_rule,
            'data.confirm_password'  => $confirm_password_rule,
            'data.address'           => ['required', 'string', 'max:150'],
            'data.phone'             => ['required', 'min:11', 'numeric', $phone_rule],
            'data.work_state'        => ['required', 'integer', 'between:0,1'],
            'data.craftsman_type_id' => ['required', 'exists:craftsmen_types,craftsman_type_id'],
            'data.city_id'           => ['required', 'exists:cities,city_id'],
            'data.description'       => ['string'],
            'data.craftsman_img.url' => ['image', 'mimes:jpg,jpeg,png'],
            'data.craftsman_img.alt' => ['string'],
        ];


    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }}
