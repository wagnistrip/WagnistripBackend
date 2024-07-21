<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Route;

class AdminLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
      return view('admin.adminlogin');
    }
    
    public function loginPost(Request $request)
    {
      // // Validate the form data
       $this->validate($request, [
         'email'   => 'required|email',
         'password' => 'required|min:8'
       ]);
      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        // if successful, then redirect to their intended location
        return redirect()->intended(route('admin.dashboard.admin'));
      } 
      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->with('error','Email OR Password is incorrect');
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }


}
