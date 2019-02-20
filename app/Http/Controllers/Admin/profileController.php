<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

//課題１８
use App\History;
use Carbon\Carbon;

class ProfileController extends Controller
{
    //課題４.５
    public function add(){
      return view('admin.profile.create');
    }

    public function create(Request $request){
      $this->validate($request, Profile::$rules);
      $profile = new Profile;
      $form = $request->all();

      unset($form['_token'] );

      //ここが間違ってる？
      $profile->fill($form);
      $profile->save();


      return redirect('admin/profile/create');
    }

    public function edit(Request $request){
      $profile = Profile::find($request->id);
      if (empty($profile)){
        abort(404);
      }
      return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $request){
      $this->validate($request,Profile::$rules);
      $profile = Profile::find($request->id);
      $profile_form = $request->all();
      unset($profile_form['_token']);
      $profile->fill($profile_form)->save();

      //課題１８
      $bobsapbackground = new Bobsapbackground;
      $bobsapbackground->profile_id = $profile->id;
      $bobsapbackground->edited_at = Carbon::now();
      $bobsapbackground->save();

      return redirect('admin/profile');
    }
}
