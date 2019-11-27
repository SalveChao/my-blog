<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\VerifyIsAdmin as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if(!auth()->user()->isAdmin()){
         return redirect()->back();
        }
    }
}
