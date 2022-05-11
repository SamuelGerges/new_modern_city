<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateCraftsman extends Model
{
    protected $table = 'rate_craftsmen';
    protected $primaryKey = 'rate_craftsman_id';
    protected $fillable = ['craftsman_id','user_id','rate'];
    protected $guarded = ['rate_craftsman_id'];



}
