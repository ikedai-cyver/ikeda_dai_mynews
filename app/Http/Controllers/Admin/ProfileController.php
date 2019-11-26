<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;
use App\Profile_histories;
use Carbon\Carbon;

class ProfileController extends Controller
{
    
    public function add()
    {
       
        
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
        
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
        \Debugbar::info($request);
        $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);    
      }
      return view('admin.profile.edit', ['profiles_form' => $profile]);
      
    }
    
    public function update(Request $request)
    {
        \Debugbar::info($request);
        $this->validate($request, Profile::$rules);
      $profile = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $profiles_form = $request->all();
      
      unset($profiles_form['_token']);
      // 該当するデータを上書きして保存する
      $profile->fill($profiles_form)->save();
      
      
      $profile_histories = new Profile_histories;
      $profile_histories->profile_id = $profile->id;
      $profile_histories->edited_at = Carbon::now();
      $profile_histories->save();

      return redirect('admin/profile/create');;
    }
}
