<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  protected $guarded = array('id');
  public static $rules = array(
    'name' => 'required',
    'gender' => 'required',
    'hobby' => 'required',
    'introduction' => 'required',
  );

  //課題１８
  public function bobsapbackgrounds(){
    return $this->hasMany('App\Bobsapbackground');
  }
}
