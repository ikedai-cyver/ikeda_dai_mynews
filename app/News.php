<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model//Validationを定義
{
    protected $guarded = array('id');

    
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    
    // Newsモデルに関連付けを行う
    public function histories()
    {
      return $this->hasMany('App\History');//newsテーブルに関連づいているhistoriesテーブルを全て取得するというメソッド

    }
    
}