<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class Craftsman extends Authenticatable implements JWTSubject
{
    protected $table = 'craftsmen';
    protected $primaryKey = 'craftsman_id';
    protected $guarded = ['craftsman_id','city_id','craftsman_type_id','token'];
    protected $fillable = [
       'first_name', 'last_name', 'email', 'gender', 'password', 'address', 'phone', 'status','craftsman_type_id',
        'city_id', 'description','craftsman_img','craftsman_slider','token',
    ];


    protected $hidden = [
        'password','craftsman_img','craftsman_slider','created_at','updated_at',
    ];


    public function getStatusAttribute($val)
    {
        return $val === 0 ? 'Not Active' : 'Active';
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }



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
            'data.description'       => ['nullable', 'string'],
            'data.craftsman_img.url' => ['image', 'mimes:jpg,jpeg,png'],
            'data.craftsman_img.alt' => ['string'],
        ];


    }


    public static function show_craftsman_by_type($craftsman_type_id)
    {
        /*************** return all craftsman by craftsman_type_id ****************/
        $crafts = DB::table('craftsmen')
            ->select('craftsman_id', 'first_name','last_name','description' ,'craftsman_img','craftsmen_types.craftsman_type_name')
            ->join('craftsmen_types', 'craftsmen.craftsman_type_id', '=', 'craftsmen_types.craftsman_type_id')
            ->where('craftsmen_types.craftsman_type_id' , '=', $craftsman_type_id)
            ->get();
        return $crafts;
    }

    public static function works_of_craftsman($crafts_id)
    {
        $craftsman_works = DB::table('craftsmen')
            ->select('craftsman_slider')
            ->where('craftsman_id','=',$crafts_id)
            ->get();
        return $craftsman_works;
    }
    public static function show_datails_of_craftsman($crafts_id)
    {
        // TODO: return details of place

        $craftsman_details = DB::table('craftsmen')
            ->select('craftsman_id','first_name', 'last_name', 'email', 'gender',
                'address', 'phone', 'status','craftsman_type_id',
                'city_id', 'description','craftsman_img','craftsman_slider')
            ->where('craftsman_id','=',$crafts_id)
            ->get();
        return $craftsman_details;
    }
    public static function show_rate_craftsman($craftsman_id){
        $rate = DB::table('rate_craftsmen')
            ->where('craftsman_id', '=', $craftsman_id);
        if($rate->count() > 0){
            $rate_value = (int)round($rate->sum('rate') / $rate->count() );
            return $rate_value;
        }
        else{
            return 0;
        }
    }


    // TODO return Data OF USER
    public static function show_data_of_craftsman($craftsman_id)
    {
        $craftsman = DB::table('craftsmen')
            ->select(
                'craftsman_id','first_name', 'last_name', 'email', 'gender', 'address', 'phone', 'status','craftsman_type_id',
                'city_id', 'description','craftsman_img'
            )
            ->where('craftsman_id','=',$craftsman_id)->get();
        return $craftsman;
    }



}
