<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class profileController extends Controller
{
    //課題４.５
    public function add(){
      return view('admin.profile.create');
    }

    public function creat(){
      return redirect('admin/profile/create');
    }

    public function edit(){
      return view('admin.profile.edit');
    }

    public function update(){
      return redirect('admin/profile/edit');
    }
}
