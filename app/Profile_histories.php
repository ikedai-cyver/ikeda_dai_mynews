<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile_histories extends Model
{
    protected $guarded = array('id');
    
    public static $rules = array(
        'profile_id' => 'required',
        'edited_at' => 'required',
        );
}
