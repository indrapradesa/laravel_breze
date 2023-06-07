<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function create(Request $request)
    {

    }

    public function check(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.exists' => 'This email is not exists in sales table'
        ]);

        $creds = $request->only('email', 'password');

        if (Auth::guard('sales')->attempt($creds)) {
            return redirect()->route('sales.home');
        }else{
            return redirect()->route('sales.login')->with('fail', 'Incorrect Credentials');
        }
    }

    function logout(){
        Auth::guard('sales')->logout();
        return redirect('sales.login');
    }
}
