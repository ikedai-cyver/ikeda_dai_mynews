<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

class ProfileController extends Controller
{
    
    public function add()
    {
        $this->validate($request, Profile::$rules);
      
      $profile = new Profile;
      $form = $request->all();
      unset($form['_token']);
       $profile->fill($form);
      $profile->save();
        
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
        
        // 以下を追記
      // Varidationを行う
      $this->validate($request, Profile::$rules);
      
      $profile = new Profile;
      $form = $request->all();
      unset($form['_token']);
       $profile->fill($form);
      $profile->save();
        
        return redirect('admin/profile/create');
    }
    
    public function edit(Request $request)
    {
        $this->validate($request, Profile::$rules);
      
      $profile = new Profile;
      $form = $request->all();
      unset($form['_token']);
       $profile->fill($form);
      $profile->save();
      
        return view('admin.profile.edit');
    }
    
    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
      
      $profile = new Profile;
      $form = $request->all();
      unset($form['_token']);
       $profile->fill($form);
      $profile->save();
      
        return direct('admin/profile/edit');
    }
}
