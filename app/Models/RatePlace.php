<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatePlace extends Model
{
    protected $table = 'rate_places';
    protected $primaryKey = 'rate_place_id';
    protected $fillable = ['place_id','user_id','rate'];
    protected $guarded = ['rate_place_id'];



}
