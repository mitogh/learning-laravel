<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function destroy( Request $request )
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect()->route( 'home' );
    }
}
